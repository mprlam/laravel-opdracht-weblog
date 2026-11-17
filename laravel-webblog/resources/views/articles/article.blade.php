@extends('layouts.app')
@section('title', 'Artikel')
@section('content')

<article class="article">
    <header>
        @if($article->premium)
            <p class="premium-mark">Premium</p>
        @endif

        <h1 class="article-name">{{$article->name}}</h1>

        <div id="categories">
            <label for="categories-checkbox" id="category-label">Toon Categorieën</label>
            <br>
            <input type="checkbox" id="categories-checkbox" style="display: none;">
            <ul id="categories-list">
            @foreach($article->categories as $category)
                <li class="categories-list-category">{{$category->name}}</li>
            @endforeach
            </ul>
        </div>
    </header>

    <div id="article-body">
        @if(!$article->premium || Auth::check() && $hasAccess)
            @if($article->image_path)
                <img id="article-image" src="{{asset('storage/'.$article->image_path)}}">
            @endif
            <p class="article-text">{{$article->text}}</p>
        @else
            <p class="article-text" style="color: gray;">Abonneer om dit Artikel te lezen</p>
            <form action="{{ route('article.subscribe', $article) }}" method="GET">
                <button type="submit">Abonneer</button>
            </form>
        @endif
    </div>

    <footer class="article-footer">
        <p class="article-user">{{$article->user->name}}</p>
        <p class="article-date">Gepost op: <time>{{$article->created_at}}</time></p>
    </footer>
</article>

<section id="comments">
    <div id="add-comment">
        @if(Auth::check())
            <form id="comment-form" action="{{ route('comments.store', $article->id, Auth::user()->id) }}" method="POST">
                <textarea name="text" id="comment-form-text"></textarea>
                <button type="submit">Plaats Opmerking</button>
            </form>
        @else
            <a href="{{route('account.account')}}" id="comment-login-link">Login om Opmerkingen te plaatsen</a>
        @endif
    </div>
    @foreach($comments as $comment)
        <article class="comment">
            <p class="comment-text">{{$comment->text}}</p>
            <footer class="comment-footer">
                <p class="comment-user">{{$comment->user->name}}</p>
                <p class="comment-date">Gepost op: <time>{{$comment->created_at}}</time></p>
            </footer>
        </article>
    @endforeach
</section>
@endsection
