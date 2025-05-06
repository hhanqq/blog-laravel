@extends('layouts.main')

@section('title', 'Home page')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Последние посты</h1>

    @if($posts->isEmpty())
    <p class="text-muted">Постов пока нет.</p>
    @else
    <div class="row g-4">
        @foreach ($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $post->title }}</h5>

                    @if($post->tags && $post->tags->isNotEmpty())
                    <div class="mb-3">
                        @foreach ($post->tags as $tag)
                        <span class="badge bg-primary me-1 mb-1">
                            {{ $tag->title }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    <button type="button" class="btn btn-outline-primary mt-auto align-self-start"
                        data-bs-toggle="modal" data-bs-target="#postModal-{{ $post->id }}">
                        Подробнее
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        <!-- Modal -->
        <div class="modal fade" id="postModal-{{ $post->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $post->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Категория:</strong> {{ optional($post->category)->title }}</p>
                        <p>{{ $post->content }}</p>

                        @if($post->tags->isNotEmpty())
                        <div>
                            <strong>Теги:</strong>
                            @foreach ($post->tags as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag->title }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection