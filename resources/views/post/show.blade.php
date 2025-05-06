@extends('layouts.main')

@section('title', $post->title)

@section('content')
<div class="container mt-5">
    <h2>{{ $post->title }}</h2>
    <p class="text-muted">Категория: {{ optional($post->category)->title }}</p>
    <hr>
    <p>{{ $post->content }}</p>

    @if($post->tags->isNotEmpty())
    <div>
        @foreach ($post->tags as $tag)
        <span class="badge bg-secondary">{{ $tag->title }}</span>
        @endforeach
    </div>
    @endif
</div>
@endsection