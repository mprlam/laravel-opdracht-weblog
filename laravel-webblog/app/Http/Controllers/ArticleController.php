<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    /**
     * Return a list of all subscribed and/or owned articles of the current user
     */
    private function getAccessableArticles(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $subscriptions = Subscription::where('user_id', $user_id)->get();

            $subscribedArticles = Article::whereIn('id', $subscriptions->pluck('article_id'))->get();
            $ownedArticles = Article::where('user_id', $user_id)->get();
            $accessableArticles = $ownedArticles->concat($subscribedArticles)->unique();

            return $accessableArticles;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $accessableArticles = $this->getAccessableArticles();

        if ($request->has('categories')){
            $requestedCategories = Category::whereIn('id', $request['categories'])->get();
            $requestedArticles = (new Article)->newCollection();

            foreach($requestedCategories as $requestedCategory){
                // Elke for loop heeft op dit moment een query, kan dit beter?

                $requestedArticles = $requestedArticles->concat($requestedCategory->article()->get());
            }

            if($requestedArticles->isNotEmpty()){
                // maybe make it show "No Articles Found" if isEmpty?

                $articles = $requestedArticles->unique()->toQuery()->with('user:id,name')->get();
            }
        }

        $indexCollections['articles'] = isset($articles) ? $articles : Article::orderBy('created_at', 'desc')->with('user:id,name')->get();
        $indexCollections['categories'] = $categories;

        if(isset($requestedCategories)){
            $indexCollections['requestedCategories'] = $requestedCategories;
        }

        if(isset($accessableArticles) && $accessableArticles->isNotEmpty()){
            $indexCollections['accessableArticles'] = $accessableArticles;
        }

        return view('articles.index', $indexCollections);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request, User $user): RedirectResponse
    {
        $request->merge(['user_id' => $user]);
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        if($request->validate(['image' => 'nullable|image|mimes:jpeg,jpg,png'])){
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        }

        if(isset($request['mark-premium'])){
            $validated['premium'] = 1;
        }

        $article = Article::create($validated);



        if($request->validate(['categories' => 'nullable|array'])){
            $article->categories()->sync($request->categories);
        }

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Zonder de ->with('user') maak je in article.blade.php queries per comment om de users te krijgen, nu maak je een query voor de comments,
        //  gevolgd door een query om hier direct alle relevante users te krijgen.
        // je mag hier ook with(['user', 'etc']) doen om meerdere models te eager loaden.

        $hasAccess = Auth::check() ? $this->getAccessableArticles()->contains($article) : null;
        
        if($article->image_path){
            $image = Storage::disk('public')->get($article->image_path);
        } else {
            $image = "";
        }
        $comments = Comment::where('article_id', $article->id)->with('user:id,name')->orderBy('created_at', 'desc')->get();
        return view('articles.article', compact('article', 'comments', 'image', 'hasAccess'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        if(! Gate::allows('update-article', $article)){
            abort(403);
        }

        $validated = $request->validated();

        if($request->validate(['image' => 'nullable|image|mimes:jpeg,jpg,png'])){
            if($article->image_path){
                Storage::disk('public')->delete($article->image_path);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $imagePath;
        } else if($request->remove_image && $article->image_path){
            Storage::disk('public')->delete($article->image_path);
            $validated['image_path'] = null;
        }

        if($request->validate(['categories' => 'nullable|array'])){
            $article->categories()->sync($request->categories);
        }

        if(isset($request['mark-premium'])){
            $validated['premium'] = 1;
        } else {
            $validated['premium'] = 0;
        }
        
        $article->update($validated);

        return redirect()->intended();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if(! Gate::allows('update-article', $article)){
            abort(403);
        }
        if($article->image_path){
            Storage::disk('public')->delete($article->image_path);
        }
        $article->delete();
        return redirect()->route('account.account');
    }

    public function subscribe(Article $article){
        $user = Auth::user();
        $accessableArticles = $this->getAccessableArticles();

        if($accessableArticles->contains($article)){
            return redirect()->route('articles.article', $article);
        } else {
            return view('articles.subscribe', compact('article', 'user'));
        }
    }
}
