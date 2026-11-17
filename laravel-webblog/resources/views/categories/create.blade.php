@extends('layouts.app')
@section('title', 'Create')
@section('content')
<form action="{{ route('categories.store', Auth::user()->id ) }}" method="POST">
    @csrf
    <label for="name">Nieuwe Categorie: </label>
    <input type="text" id="name" name="name" required>
    
    <button type="submit">Maak Categorie</button>
</form>

@endsection