@extends('layouts.main')

@section('title', 'Home Page')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Создать новый пост</h2>

    <form action="{{ route('post.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category_id" class="form-label">Категория</label>
            <select name="category_id" class="form-select">
                <option value="">Выберите категорию</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Название поста</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Введите заголовок">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Теги</label>
            <input type="text" name="tags" id="tags" class="form-control" placeholder="Введите теги через запятую">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить пост</button>
    </form>
</div>
@endsection