@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Pedido #{{ $order->id }}</h2>
    
    <form action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mt-3">
            <label for="status">Estado del Pedido</label>
            <select name="status" class="form-control" required>
                <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="procesando" {{ $order->status === 'procesando' ? 'selected' : '' }}>Procesando</option>
                <option value="enviado" {{ $order->status === 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="entregado" {{ $order->status === 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ $order->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary mt-4">Actualizar Pedido</button>
        <a href="{{ route('order.show', $order->id) }}" class="btn btn-secondary mt-4 ml-2">Cancelar</a>
    </form>
</div>
@endsection
