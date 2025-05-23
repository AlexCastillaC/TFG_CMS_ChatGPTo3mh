@extends('layouts.app')

@section('title', 'Detalles del Puesto')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles del Puesto</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $stand->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $stand->description }}</p>
            <p><strong>Ubicación:</strong> {{ $stand->location }}</p>
            <p><strong>Categoría:</strong> {{ $stand->category }}</p>
            @if($stand->stand_picture)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $stand->stand_picture) }}" alt="Imagen del puesto" class="img-fluid">
                </div>
            @endif
            <p><strong>Creado:</strong> {{ $stand->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('stand.edit', $stand->id) }}" class="btn btn-primary">Editar Puesto</a>
            <form action="{{ route('stand.destroy', $stand->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Eliminar el puesto?')">Eliminar Puesto</button>
            </form>
        </div>
    </div>
</div>
@endsection
