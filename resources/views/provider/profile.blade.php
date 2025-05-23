@extends('layouts.app')

@section('content')
    <link href="css/app.css" rel="stylesheet">
    <h2>Perfil del Proveedor</h2>

    <!-- Enlaces para la gestión del puesto -->
    <div class="mb-4">
        @if($user->stand)
            <a href="{{ route('stand.show', $user->stand->id) }}" class="btn btn-info">Ver mi puesto</a>
        @else
            <a href="{{ route('stand.create') }}" class="btn btn-success">Crear mi puesto</a>
        @endif
    </div>

    <div class="mb-4">
        <a href="{{ route('provider.products.index') }}" class="btn btn-info">Ver mis productos</a>
        <a href="{{ route('provider.products.create') }}" class="btn btn-success">Crear nuevo producto</a>
    </div>
    <form action="{{ route('provider.profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control"
                placeholder="Ingresa tu nombre" required>
        </div>
        <div class="form-group mt-3">
            <label for="phone">Teléfono</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control"
                placeholder="Ingresa tu número de teléfono">
        </div>
        <div class="form-group mt-3">
            <label for="profile_picture">Foto de Perfil</label>
            @if($user->profile_picture)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto de Perfil" class="img-thumbnail"
                        style="max-width: 150px;">
                </div>
            @endif
            <input type="file" name="profile_picture" class="form-control-file">
        </div>
        <!-- Puedes agregar más campos aquí según tus requerimientos -->
        <button type="submit" class="btn btn-primary mt-4">Actualizar Perfil</button>
    </form>
@endsection