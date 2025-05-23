@extends('layouts.app')

@section('title', 'Detalles del Producto')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles del Producto</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $product->description }}</p>
            <p><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Categoría:</strong> {{ $product->category }}</p>
            <p><strong>Disponibilidad:</strong> {{ $product->is_available ? 'Disponible' : 'No disponible' }}</p>
            <p><strong>Creado el:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
            <p><strong>Actualizado el:</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('provider.products.index') }}" class="btn btn-secondary">Volver a la lista</a>
            <a href="{{ route('provider.products.edit', $product->id) }}" class="btn btn-primary">Editar Producto</a>
        </div>
    </div>
</div>
@endsection
