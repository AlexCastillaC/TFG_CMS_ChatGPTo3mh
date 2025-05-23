@extends('layouts.app')

@section('title', 'Puestos')

@section('content')
<div class="container">
    <h2 class="mb-4">Puestos Disponibles</h2>
    <div class="row">
        @foreach($stands as $stand)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    @if($stand->stand_picture)
                        <img src="{{ asset('storage/' . $stand->stand_picture) }}" class="card-img-top" alt="{{ $stand->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $stand->name }}</h5>
                        <p class="card-text">{{ Str::limit($stand->description, 80) }}</p>
                        <p class="card-text"><strong>Ubicación:</strong> {{ $stand->location }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('stand.show', $stand->id) }}" class="btn btn-primary btn-block">Ver Puesto</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $stands->appends(request()->query())->links() }}
</div>
@endsection
