@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
    <div class="container">
        <h2 class="mb-4">Editar Producto</h2>
        <form action="{{ route('vendor.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="form-group mt-3">
                <label for="description">Descripción</label>
                <textarea name="description" class="form-control"
                    rows="4">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="price">Precio</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0.01"
                        value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" class="form-control" min="0"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="category">Categoría</label>
                    <select name="category" class="form-control">
                        <option value="">Seleccione una categoría</option>
                        <option value="Frutas" {{ old('category', $product->category) == 'Frutas' ? 'selected' : '' }}>Frutas
                        </option>
                        <option value="Verduras" {{ old('category', $product->category) == 'Verduras' ? 'selected' : '' }}>
                            Verduras</option>
                        <option value="Carnes" {{ old('category', $product->category) == 'Carnes' ? 'selected' : '' }}>Carnes
                        </option>
                        <option value="Pescado" {{ old('category', $product->category) == 'Pescado' ? 'selected' : '' }}>
                            Pescado</option>
                        <option value="Lácteos" {{ old('category', $product->category) == 'Lácteos' ? 'selected' : '' }}>
                            Lácteos</option>
                        <option value="Panadería" {{ old('category', $product->category) == 'Panadería' ? 'selected' : '' }}>
                            Panadería</option>
                        <option value="Dulces" {{ old('category', $product->category) == 'Dulces' ? 'selected' : '' }}>Dulces
                        </option>
                        <option value="Bebidas" {{ old('category', $product->category) == 'Bebidas' ? 'selected' : '' }}>
                            Bebidas</option>
                        <option value="Artesanía" {{ old('category', $product->category) == 'Artesanía' ? 'selected' : '' }}>
                            Artesanía</option>
                        <option value="Otros" {{ old('category', $product->category) == 'Otros' ? 'selected' : '' }}>Otros
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="is_available">Disponibilidad</label>
                <select name="is_available" class="form-control" required>
                    <option value="1" {{ $product->is_available ? 'selected' : '' }}>Disponible</option>
                    <option value="0" {{ !$product->is_available ? 'selected' : '' }}>No disponible</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Actualizar Producto</button>
        </form>
    </div>
@endsection