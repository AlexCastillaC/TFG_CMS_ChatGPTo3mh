@extends('layouts.app')

@section('title', 'Detalles del Pedido')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles del Pedido #{{ $order->id }}</h2>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Información del Pedido
        </div>
        <div class="card-body">
            <p><strong>Total sin IVA:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Total con IVA (21%):</strong> ${{ number_format($order->total_with_iva, 2) }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Método de Pago:</strong> {{ $order->payment_method }}</p>
            <p><strong>Estado del Pago:</strong> {{ ucfirst($order->payment_status) }}</p>
            <p><strong>Dirección de Envío:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    
    <h3>Productos del Pedido</h3>
    @if($order->items->count())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No hay productos asociados a este pedido.</p>
    @endif
    
    <a href="{{ route('order.history') }}" class="btn btn-secondary mt-3">Volver al Historial de Pedidos</a>
</div>
@endsection
