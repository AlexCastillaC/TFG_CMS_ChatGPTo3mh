@extends('layouts.app')

@section('title', $forum->title)

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $forum->title }}</h2>
    <p>{{ $forum->description }}</p>
    
    <a href="{{ route('topics.create', $forum->id) }}" class="btn btn-primary mb-3">Crear Nuevo Tema</a>
    
    <h4>Temas</h4>
    @if($forum->topics->count())
        <div class="list-group">
            @foreach($forum->topics as $topic)
                <a href="{{ route('topics.show', [$forum->id, $topic->id]) }}" class="list-group-item list-group-item-action">
                    <h5>{{ $topic->title }}</h5>
                    <p>{{ Str::limit($topic->content, 100) }}</p>
                </a>
            @endforeach
        </div>
    @else
        <p>No hay temas en este foro.</p>
    @endif
</div>
@endsection
