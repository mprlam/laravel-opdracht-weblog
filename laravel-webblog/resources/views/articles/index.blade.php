@extends('layouts.app')
@section('title', 'Artikelen')
@section('content')
<section id="articles">
    <h1>Artikelen</h1>
    <form action="{{ route('articles.index') }}" method="GET">
        <input type="checkbox" id="add-categories-checkbox" style="display: none;">
        <label for="add-categories-checkbox" id="add-category-label">Categorieën</label>

        <ul id="add-categories-list">
            @foreach($categories as $category)
                <li class="add-categories-list-category">
                    <label class="add-categories-list-label">
                        <input 
                            type="checkbox" 
                            class="add-categories-list-input"
                            style="display: none;" 
                            id="{{$category->name}}" 
                            name="categories[]" 
                            value="{{$category->id}}" 
                            @if(isset($requestedCategories)) 
                                @if($requestedCategories->contains($category->id)) 
                                checked 
                                @endif 
                            @endif 
                        >
                        {{$category->name}}
                    </label>
                </li>
            @endforeach
        </ul>
        <button id="filter-categories-button" type="submit">Filter</button>
    </form>

    @foreach($articles as $article)
        <article>
            <a href="{{ route('articles.article', $article) }}" class="article clickable-article">
                <header>
                    @if($article->premium)
                        <p class="premium-mark">Premium</p>
                    @endif

                    <h2 class="article-name">{{$article->name}}</h2>
                </header>

                <div>
                    @if(!$article->premium || Auth::check() && $accessableArticles->contains($article))
                        <p class="home-article-text article-text">{{$article->text}}</p>
                    @else
                        <p class="home-article-text article-text" style="color: gray;">Subscribe to read Article</p>
                        <form action="{{ route('article.subscribe', $article) }}" method="GET" style="z-index: 2">
                            <button type="submit">Subscribe</button>
                        </form>
                    @endif
                </div>

                <footer class="article-footer">
                    <p class="article-user">{{$article->user->name}}</p>
                    <p class="article-date">Posted: <time>{{$article->created_at}}</time></p>
                </footer>
            </a>
        </article>
    @endforeach
</section>
@endsection