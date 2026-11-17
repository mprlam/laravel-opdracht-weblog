@extends('layouts.app')
@section('title', 'Edit')
@section('content')
<form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="name">Titel:</label>
    <input type="text" id="name" name="name" value="{{ $article->name }}" required>
    <br>
    <div id="add-categories">
        <label for="add-categories-checkbox" id="add-category-label">Voeg Categorieën Toe:</label>
        <br>
        <input type="checkbox" id="add-categories-checkbox" style="display: none;">
        <ul id="add-categories-list">
        @foreach($categories as $category)
            <li class="add-categories-list-category">
                <label class="add-categories-list-label">
                    <input 
                        type="checkbox" 
                        class="add-categories-list-input" 
                        id="{{$category->name}}" 
                        name="categories[]" 
                        value="{{$category->id}}" 
                        style="display: none;"
                        @if($article->categories->contains($category->id))
                        checked
                        @endif
                        >
                    {{$category->name}}
                </label>
            </li>
        @endforeach
        </ul>
    </div>

    @if($article->image_path)
        <label>
            Verwijder Afbeelding: <input type="checkbox" id="remove-image" name="remove_image">
        </label>
        <img id="article-image" src="{{asset('storage/'.$article->image_path)}}">
        <br>
        <label for="add-image">Verander Afbeelding:</label>
    @else
        <label for="add-image">Voeg een Afbeelding toe:</label>
    @endif

    <input type="file" id="add-image" name="image" accept=".jpg, .png, .jpeg">
    <br>
    <div>
        <label for="mark-premium">Premium: </label>
        <input type="checkbox" name="mark-premium"
        @if($article->premium)
        checked
        @endif
        >
    </div>
    <br>
    <textarea id="edit-article-text" name="text">{{ $article->text }}</textarea>
    <br>

    <button type="submit">Edit</button>

    @if ($errors->has('image'))
       <span class="alert">
            Afbeelding moet .jpg, .png, of .jpeg zijn.
       </span>
    @endif
</form>
@endsection
