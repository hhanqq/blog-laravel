@extends('layouts.main')


@section('title', 'Home page')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1 class="h2">Регистрация</h1>

        <form action="{{ route('user.store') }}" method="post">
            @csrf


            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input name="name" type="name"
                    class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Имя">
            </div>


            <div class="mb-3">
                <label for="surname" class="form-label">Фамилия</label>
                <input name="surname" type="surnname"
                    class="form-control @error('surname') is-invalid @enderror" id="surname" placeholder="Фамилия">
            </div>


            <div class="mb-3">
                <label for="nickname" class="form-label">Никнейм</label>
                <input name="nickname" type="nickname"
                    class="form-control @error('nickname') is-invalid @enderror" id="nickname" placeholder="Никнейм">
            </div>


            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Почта">
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input name="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Пароль">
            </div>


            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтвердить пароль</label>
                <input name="password_confirmation" type="password"
                    class="form-control" id="password_confirmation" placeholder="Повторите пароль">
            </div>


            <button type="submit" class="btn btn-primary">Регистрация</button>
            <a href="{{ route('login') }}" class="ms-3">Уже зарегестрирован?</a>
        </form>

    </div>

</div>
@endsection