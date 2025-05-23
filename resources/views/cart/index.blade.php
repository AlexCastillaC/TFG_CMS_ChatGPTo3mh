@extends('layouts.app')

@section('title', 'Carrito de Compra')

@section('content')
<div class="container">
    <h2 class="mb-4">Carrito de Compra</h2>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(count($cart))
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="form-inline">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" class="form-control form-control-sm mr-2" min="1">
                                <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                            </form>
                        </td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceder al Checkout</a>
    @else
        <p>No hay productos en el carrito.</p>
    @endif
</div>
@endsection
