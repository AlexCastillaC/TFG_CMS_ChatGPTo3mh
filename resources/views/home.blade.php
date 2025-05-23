@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                @section('content')
                <div class="container">
    <!-- Widget de Clima -->
    <div id="weather-widget" class="mb-4">
        <h3>Clima en San Mateo</h3>
        <div id="weather-data">
            <p>Cargando clima...</p>
        </div>
    </div>
    
    <!-- Sección de Productos Destacados -->
    <div id="featured-products-section" class="mb-4">
        <h3>Productos Destacados</h3>
        <div id="featured-products" class="row">
            <p>Cargando productos destacados...</p>
        </div>
    </div>
    
    <!-- Buscador de Productos -->
    <div id="product-search-section" class="mb-4">
        <h3>Buscar Productos</h3>
        <form id="product-search-form" class="form-inline mb-3">
            <input type="text" id="search-input" name="q" class="form-control mr-2" placeholder="Buscar productos...">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <div id="search-results" class="row">
            <!-- Los resultados se cargarán aquí -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Cargar los scripts específicos para la página de inicio -->
<script src="{{ asset('js/featured-products.js') }}"></script>
<script src="{{ asset('js/product-search.js') }}"></script>
<script>
    // AJAX para actualizar el widget de clima
    $(document).ready(function(){
        console.log("Cargando datos del clima...");
        $.ajax({
            url: '/api/clima',
            method: 'GET',
            dataType: 'json',
            success: function(data){
                console.log("Clima recibido:", data);
                let html = `
                    <p><strong>Temperatura:</strong> ${data.temperature} °C</p>
                    <p><strong>Condición:</strong> ${data.condition}</p>
                    <p><strong>Humedad:</strong> ${data.humidity} %</p>
                    <p><strong>Viento:</strong> ${data.wind_speed} m/s</p>
                `;
                $('#weather-data').html(html);
            },
            error: function(xhr, status, error){
                console.error("Error obteniendo el clima:", error);
                $('#weather-data').html('<p>Error al cargar el clima.</p>');
            }
        });
    });
</script>
@endsection
            </div>
        </div>
    </div>
</div>
@endsection
