@extends('layouts.app')
@section('title', 'Categorieën')
@section('content')
@if(Auth::check())
    <form action="{{ route('categories.create', Auth::user()->id ) }}" method="GET">
        <button type="submit" id="create_category">Maak een nieuwe Categorie</button>
    </form>
@else
    <a href="{{route('account.account')}}">Login om een nieuwe Categorie te maken.</a>
@endif

<div id="categories">
    <h1>Categorieën</h1>
    <ul>
        @foreach($categories as $category)
            <li class="category-name">{{$category->name}}</li>
        @endforeach
    </ul>
</div>

@endsection