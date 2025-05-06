@extends('layouts.main')

@section('title', 'Home page')

@section('content')
<h1 class="h2">Логин</h1>

<form action="{{ route('login.auth') }}" method="post">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Почта</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="Почта">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">
    </div>


    <button type="submit" class="btn btn-primary">Логин</button>

    <a href="{{ route('password.request') }}" class="mt-2">Забыли пароль?</a>

</form>

@endsection