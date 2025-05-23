@extends('layouts.app')

@section('title', 'Crear Tema')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nuevo Tema en {{ $forum->title }}</h2>
    <form action="{{ route('topics.store', $forum->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Título del Tema</label>
            <input type="text" name="title" class="form-control" required placeholder="Título del tema">
        </div>
        <div class="form-group mt-3">
            <label for="content">Contenido</label>
            <textarea name="content" class="form-control" rows="5" required placeholder="Contenido del tema"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Crear Tema</button>
    </form>
</div>
@endsection
