@extends('layouts.app')

@section('title', 'Crear Puesto')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Puesto</h2>
    <form action="{{ route('stand.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nombre del Puesto</label>
            <input type="text" name="name" class="form-control" placeholder="Nombre del puesto" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Descripción del puesto"></textarea>
        </div>
        <div class="form-group mt-3">
            <label for="location">Ubicación</label>
            <input type="text" name="location" class="form-control" placeholder="Ubicación en el mercado" required>
        </div>
        <div class="form-group mt-3">
            <label for="category">Categoría</label>
            <input type="text" name="category" class="form-control" placeholder="Ej. Frutas, Artesanía, etc.">
        </div>
        <div class="form-group mt-3">
            <label for="stand_picture">Imagen del Puesto</label>
            <input type="file" name="stand_picture" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Crear Puesto</button>
    </form>
</div>
@endsection
