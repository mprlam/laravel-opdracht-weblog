@extends('layouts.app')
@section('title', 'Account')
@section('content')
<div id="articles">
    <h1>Jouw Artikelen:</h1>

    @if($articles->isEmpty())
        <p>Nog geen artikelen</p>
    @endif

    <a href="{{ route('articles.create') }}">Maak een nieuw artikel</a>
    
    @foreach($articles as $article)
    <div class="article">
        <h1 class="article-name">{{$article->name}}</h1>
        <p class="article-text">{{$article->text}}</p>
        <div class="article-footer">
            <div class="article-buttons">
                <form action="{{ route('articles.edit', $article) }}" class="article-edit" method="GET">
                    <button type="submit">Aanpassen</button>
                </form>
                <form action="{{ route('articles.destroy', $article) }}" class="article-delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Verwijderen</button>
                </form>
            </div>
            <p class="article-date">{{$article->created_at}}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection