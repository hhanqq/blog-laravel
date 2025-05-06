@extends('layouts.main')


@section('title', 'Home page')

@section('content')

    <div class="alert alert-info" role="alert">
        Спасибо за регистрацию! Ссылка для подтверждения
        отправлена на вашу почту.
    </div>
    
    <div>
        Не получили письмо?
        <form method="post" action="{{ route('verification.send') }}">
            @csrf
            <button type="sumbit" class="btn btn-link ps-0">Отправить ссылку</button>
        </form>
    </div>

@endsection