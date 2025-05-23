@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Producto</h2>
    <form action="{{ route('vendor.products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" placeholder="Nombre del producto" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Descripción del producto"></textarea>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <label for="price">Precio</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0.01" required>
            </div>
            <div class="col-md-4">
                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control" min="0" required>
            </div>
            <div class="col-md-4">
                <label for="category">Categoría</label>
                <input type="text" name="category" class="form-control" placeholder="Categoría">
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="is_available">Disponibilidad</label>
            <select name="is_available" class="form-control" required>
                <option value="1">Disponible</option>
                <option value="0">No disponible</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Crear Producto</button>
    </form>
</div>
@endsection
