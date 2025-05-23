@extends('layouts.app')

@section('title', 'Crear Foro')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nuevo Foro</h2>
    <form action="{{ route('forums.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" required placeholder="Título del foro">
        </div>
        <div class="form-group mt-3">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Descripción del foro"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Crear Foro</button>
    </form>
</div>
@endsection
