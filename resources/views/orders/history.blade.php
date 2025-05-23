@extends('layouts.app')

@section('title', 'Historial de Pedidos')

@section('content')
<div class="container">
    <h2 class="mb-4">Historial de Pedidos</h2>

    <!-- Tabla de pedidos encargados por el usuario (buyer) -->
    <h3>Pedidos Encargados por Ti</h3>
    @if($buyerOrders->count())
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buyerOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tienes pedidos encargados por ti.</p>
    @endif

    <!-- Si el usuario es vendedor o proveedor, se muestra la segunda tabla -->
    @if($sellerOrders)
        <h3 class="mt-5">Pedidos Encargados a Ti</h3>
        @if($sellerOrders->count())
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellerOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No tienes pedidos encargados a ti.</p>
        @endif
    @endif
</div>
@endsection
