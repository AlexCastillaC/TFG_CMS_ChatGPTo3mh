@extends('layouts.app')

@section('title', 'Editar Puesto')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Puesto</h2>
    <form action="{{ route('stand.update', $stand->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre del Puesto</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $stand->name) }}" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $stand->description) }}</textarea>
        </div>
        <div class="form-group mt-3">
            <label for="location">Ubicación</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $stand->location) }}" required>
        </div>
        <div class="form-group mt-3">
            <label for="category">Categoría</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $stand->category) }}">
        </div>
        <div class="form-group mt-3">
            <label for="stand_picture">Imagen del Puesto</label>
            @if($stand->stand_picture)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $stand->stand_picture) }}" alt="Imagen del puesto" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" name="stand_picture" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Actualizar Puesto</button>
    </form>
</div>
@endsection
