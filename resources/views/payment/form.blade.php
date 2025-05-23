@extends('layouts.app')

@section('title', 'Realizar Pago')

@section('content')
<div class="container">
    <h2 class="mb-4">Procesar Pago</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <!-- Formulario de pago con Stripe.js -->
    <form id="payment-form" action="{{ route('payment.process') }}" method="POST">
        @csrf
        <!-- Stripe insertará el elemento de la tarjeta aquí -->
        <div class="form-group">
            <label for="card-element">Información de la tarjeta</label>
            <div id="card-element" class="form-control"></div>
            <div id="card-errors" role="alert" class="mt-2 text-danger"></div>
        </div>
        <!-- Campo oculto para almacenar el token de pago -->
        <input type="hidden" name="payment_method" id="payment_method">
        <button type="submit" class="btn btn-primary mt-3">Pagar $10.00</button>
    </form>
</div>
@endsection

@section('scripts')
<!-- Incluye Stripe.js desde el CDN -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configura Stripe con tu clave pública (asegúrate de tener STRIPE_KEY en .env)
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    var elements = stripe.elements();
    var cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a'
            }
        }
    });
    cardElement.mount('#card-element');

    // Mostrar errores en tiempo real
    cardElement.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Procesar el formulario y obtener el token
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const { token, error } = await stripe.createToken(cardElement);
        if (error) {
            // Mostrar error al usuario
            document.getElementById('card-errors').textContent = error.message;
        } else {
            // Asigna el token al campo oculto y envía el formulario
            document.getElementById('payment_method').value = token.id;
            form.submit();
        }
    });
</script>
@endsection
