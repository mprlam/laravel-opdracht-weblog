<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Show articles of Account
     */
    public function show(){
        $user = Auth::getUser();
        $articles = Article::where('user_id', $user->id)->orderBy('created_at', 'asc')->get();
        return view('account/account', compact('user', 'articles'));
    }

    public function purchase(Article $article): RedirectResponse {
        $user = Auth::user();

        if(!Subscription::where('article_id', $article->id)->where('user_id', $user->id)->first()){
            Subscription::create(['user_id' => $user->id, 'article_id' => $article->id]);
        }
        return redirect()->route('articles.article', $article);
    }
}
