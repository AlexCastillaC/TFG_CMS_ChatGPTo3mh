@extends('layouts.app')

@section('title', $topic->title)

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $topic->title }}</h2>
    <p>{{ $topic->content }}</p>
    <hr>
    <h4>Comentarios</h4>
    @if($topic->comments->count())
        @foreach($topic->comments as $comment)
            <div class="mb-2">
                <strong>{{ $comment->user->name }}:</strong>
                <p>{{ $comment->content }}</p>
                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <hr>
        @endforeach
    @else
        <p>No hay comentarios aún.</p>
    @endif
    
    <form action="{{ route('comments.store', [$topic->forum_id, $topic->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Añadir Comentario</label>
            <textarea name="content" class="form-control" rows="3" required placeholder="Escribe tu comentario..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Comentario</button>
    </form>
</div>
@endsection
