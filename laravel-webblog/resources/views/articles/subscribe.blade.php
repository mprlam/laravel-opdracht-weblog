@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <form action="{{ route('account.pay', $article)}}" id="subscribe-form" method="POST">
        @method('PUT')
        @csrf
        <button>
            Abonneer aan <strong>{{$article->name}}</strong>
        </button>
    </form>
    @if($errors->any())
        @foreach($errors as $error)
            <p class="error">{{$error}}</p>
        @endforeach
    @endif
@endsection