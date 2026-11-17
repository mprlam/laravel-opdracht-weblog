@extends('layouts.app')
@section('title', 'Maak')
@section('content')
<h1>Make a new Article:</h1>
<form action="{{ route('articles.store', Auth::user()->id ) }}" method="POST" enctype="multipart/form-data" id="create-form">
    @csrf
    <label for="name">Titel:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <div id="add-categories">
        <input type="checkbox" id="add-categories-checkbox" style="display: none;">
        <label for="add-categories-checkbox" id="add-category-label">Voeg Categorieën toe: </label>
        <ul id="add-categories-list">
        @foreach($categories as $category)
            <li class="add-categories-list-category">
                <label class="add-categories-list-label">
                    <input type="checkbox" class="add-categories-list-input" id="{{$category->name}}" name="categories[]" value="{{$category->id}}" style="display: none;">
                    {{$category->name}}
                </label>
            </li>
        @endforeach
        </ul>
    </div>
    <br>
    <div class="add-image-form-group">
        <label for="add-image">Voeg Afbeelding toe:</label>
        <input type="file" id="add-image" name="image" accept=".jpg, .png, .jpeg">
    </div>
    <br>
    <div>
        <label for="mark-premium">Premium: </label>
        <input type="checkbox" name="mark-premium">
    </div>
    <br>
    <label for="text"></label>
    <textarea id="create-article-text" name="text" required></textarea>
    <br>
    <button type="submit">Create</button>
    @if ($errors->has('image'))
       <span class="alert">
            Afbeelding moet .jpg, .png, of .jpeg zijn.
       </span>
    @endif
</form>

@endsection
