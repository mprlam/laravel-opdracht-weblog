@extends('layouts.app')
@section('title', 'Login')
@section('content')
<form action="{{ route('account.authenticate')}}" id="login-form" method="POST" >
    @csrf
    <label for="email" class="login-label">Email:</label>
    <input type="text" class="login-input" id="email" name="email" required>

    <br>
    <label for="password" class="login-label">Wachtwoord:</label>
    <input type="password" class="login-input" id="password" name="password" required>
    <br>
    <button type="submit">Inloggen</button>
</form>
@if($errors->any())
    <p class="alert">Gebruikersnaam of wachtwoord ongeldig.</p>
@endif
@endsection