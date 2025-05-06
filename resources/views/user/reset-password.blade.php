@extends('layouts.main')


@section('title', 'Home page')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1 class="h2">Восстановления пароля</h1>

        <form action="{{ route('password.update') }}" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

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
                <label for="password_confirmation" class="form-label">Повторите пароль</label>
                <input name="password_confirmation" type="password"
                    class="form-control" id="password_confirmation" placeholder="Повторите пароль">
            </div>


            <button type="submit" class="btn btn-primary">Восстановление пароля</button>
        </form>

    </div>

</div>
@endsection