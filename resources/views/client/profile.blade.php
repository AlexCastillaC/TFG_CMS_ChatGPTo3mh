@extends('layouts.app')

@section('title', 'Perfil del Cliente')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card para el perfil del cliente -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Perfil del Cliente</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                   class="form-control" placeholder="Ingresa tu nombre" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="phone">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="form-control" placeholder="Ingresa tu número de teléfono">
                        </div>
                        <div class="form-group mt-3">
                            <label for="profile_picture">Foto de Perfil</label>
                            @if($user->profile_picture)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto de Perfil" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                            <input type="file" name="profile_picture" class="form-control-file">
                        </div>
                        <!-- Puedes agregar más campos aquí según tus requerimientos -->
                        <button type="submit" class="btn btn-primary mt-4">Actualizar Perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
