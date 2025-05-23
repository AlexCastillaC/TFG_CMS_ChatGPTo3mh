@extends('layouts.app') 

@section('title', 'Productos')

@section('content')
<div class="container">
    <h2 class="mb-4">Productos Disponibles</h2>
    
    <!-- Formulario de filtrado y categorización -->
    <div class="mb-4">
        <form action="{{ route('products.display') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">Todas las categorías</option>
                        <option value="Frutas" {{ request('category') == 'Frutas' ? 'selected' : '' }}>Frutas</option>
                        <option value="Verduras" {{ request('category') == 'Verduras' ? 'selected' : '' }}>Verduras</option>
                        <option value="Carnes" {{ request('category') == 'Carnes' ? 'selected' : '' }}>Carnes</option>
                        <option value="Pescado" {{ request('category') == 'Pescado' ? 'selected' : '' }}>Pescado</option>
                        <option value="Lácteos" {{ request('category') == 'Lácteos' ? 'selected' : '' }}>Lácteos</option>
                        <option value="Panadería" {{ request('category') == 'Panadería' ? 'selected' : '' }}>Panadería</option>
                        <option value="Dulces" {{ request('category') == 'Dulces' ? 'selected' : '' }}>Dulces</option>
                        <option value="Bebidas" {{ request('category') == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                        <option value="Artesanía" {{ request('category') == 'Artesanía' ? 'selected' : '' }}>Artesanía</option>
                        <option value="Otros" {{ request('category') == 'Otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="order_by" class="form-control">
                        <option value="">Ordenar por</option>
                        <option value="price" {{ request('order_by') == 'price' ? 'selected' : '' }}>Precio</option>
                        <option value="created_at" {{ request('order_by') == 'created_at' ? 'selected' : '' }}>Fecha de Creación</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="order_dir" class="form-control">
                        <option value="asc" {{ request('order_dir') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('order_dir') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Listado de productos -->
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="card-footer">
                        @if((!$user || $user->role === 'cliente') && $product->user->role === 'vendedor')
                            <!-- Clientes e invitados pueden añadir productos de vendedores -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block">Añadir al carrito</button>
                            </form>
                        @elseif($user && $user->role === 'vendedor' && $product->user->role === 'proveedor')
                            <!-- Vendedores pueden añadir productos de proveedores -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block">Añadir al carrito</button>
                            </form>
                        @elseif($user && $user->role === 'proveedor')
                            <!-- Los proveedores no pueden comprar -->
                            <span class="badge badge-secondary">No disponible para compra</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
