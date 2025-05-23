@extends('layouts.app')

@section('title', 'Mis Productos')

@section('content')
    <div class="container">
        <h2 class="mb-4">Mis Productos</h2>

        <!-- Formulario de filtros y búsqueda -->
        <form method="GET" action="{{ route('vendor.products.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Buscar..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-control">
                        <option value="">Todas las categorías</option>
                        <option value="Frutas" {{ request('category') == 'Frutas' ? 'selected' : '' }}>Frutas</option>
                        <option value="Verduras" {{ request('category') == 'Verduras' ? 'selected' : '' }}>Verduras</option>
                        <option value="Carnes" {{ request('category') == 'Carnes' ? 'selected' : '' }}>Carnes</option>
                        <option value="Pescado" {{ request('category') == 'Pescado' ? 'selected' : '' }}>Pescado</option>
                        <option value="Lácteos" {{ request('category') == 'Lácteos' ? 'selected' : '' }}>Lácteos</option>
                        <option value="Panadería" {{ request('category') == 'Panadería' ? 'selected' : '' }}>Panadería
                        </option>
                        <option value="Dulces" {{ request('category') == 'Dulces' ? 'selected' : '' }}>Dulces</option>
                        <option value="Bebidas" {{ request('category') == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                        <option value="Artesanía" {{ request('category') == 'Artesanía' ? 'selected' : '' }}>Artesanía
                        </option>
                        <option value="Otros" {{ request('category') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>

                </div>
                <div class="col-md-2">
                    <select name="availability" class="form-control">
                        <option value="">Disponibilidad</option>
                        <option value="true" {{ request('availability') === 'true' ? 'selected' : '' }}>Disponible</option>
                        <option value="false" {{ request('availability') === 'false' ? 'selected' : '' }}>No disponible
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order_by" class="form-control">
                        <option value="">Ordenar por</option>
                        <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Precio</option>
                        <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Fecha de
                            creación</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="order_dir" class="form-control">
                        <option value="asc" {{ request('order_dir') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('order_dir') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <a href="{{ route('vendor.products.create') }}" class="btn btn-success mb-3">Crear Producto</a>

        @if($products->count())
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Disponibilidad</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr @if($product->stock < 5) class="table-warning" @endif>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->is_available ? 'Sí' : 'No' }}</td>
                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('vendor.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                                    </form>

                                </td>
                            </tr>
                            @if($product->stock < 5)
                                <tr>
                                    <td colspan="7">
                                        <div class="alert alert-warning mb-0" role="alert">
                                            ¡Atención! El producto <strong>{{ $product->name }}</strong> tiene un stock bajo
                                            ({{ $product->stock }} unidades).
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $products->appends(request()->query())->links() }}
        @else
            <p>No se encontraron productos.</p>
        @endif
    </div>
@endsection