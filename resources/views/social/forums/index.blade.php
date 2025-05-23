@extends('layouts.app')

@section('title', 'Foros')

@section('content')
<div class="container">
    <h2 class="mb-4">Foros</h2>
    @if($forums->count())
        <div class="list-group">
            @foreach($forums as $forum)
                <a href="{{ route('forums.show', $forum->id) }}" class="list-group-item list-group-item-action">
                    <h5>{{ $forum->title }}</h5>
                    <p>{{ Str::limit($forum->description, 100) }}</p>
                </a>
            @endforeach
        </div>
        {{ $forums->links() }}
    @else
        <p>No hay foros disponibles.</p>
    @endif
    <a href="{{ route('forums.create') }}" class="btn btn-primary mt-3">Crear Nuevo Foro</a>
</div>
@endsection
