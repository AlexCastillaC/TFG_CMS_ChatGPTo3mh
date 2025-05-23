@extends('layouts.app')

@section('title', 'Procesar Pago')

@section('content')
<div class="container">
    <h2>Procesar Pago</h2>
    <p>Orden #{{ $order->id }} - Total: ${{ number_format($order->total, 2) }}</p>
    
    <!-- Aquí se incluiría el formulario o redirección real a la pasarela de pago -->
    <form action="{{ route('payment.callback') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <!-- Simulamos un pago exitoso -->
        <input type="hidden" name="status" value="success">
        <button type="submit" class="btn btn-primary">Simular Pago Exitoso</button>
    </form>
</div>
@endsection
