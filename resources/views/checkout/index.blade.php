@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h2 class="mb-4">Proceso de Checkout</h2>
    
    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="shipping_address">Dirección de Envío</label>
            <textarea name="shipping_address" class="form-control" rows="3" placeholder="Ingresa tu dirección de envío" required>{{ old('shipping_address') }}</textarea>
        </div>
        <div class="form-group mt-3">
            <label for="payment_method_select">Método de Pago</label>
            <select id="payment_method_select" name="payment_method" class="form-control" required>
                <option value="">Selecciona un método de pago</option>
                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                <option value="transferencia">Transferencia Bancaria</option>
                <!-- Se pueden agregar más opciones -->
            </select>
        </div>

        <!-- Contenedor para Stripe Card Element -->
        <div class="form-group mt-3" id="stripe-card-container" style="display: none;">
            <label for="card-element">Información de la Tarjeta</label>
            <div id="card-element" class="form-control"></div>
            <div id="card-errors" role="alert" class="mt-2 text-danger"></div>
        </div>
        
        <!-- Campo oculto para almacenar el token de Stripe -->
        <input type="hidden" name="stripe_token" id="stripe_token">
        
        <h4 class="mt-4">Resumen del Carrito</h4>
        <table class="table table-bordered mt-2">
            <thead class="thead-light">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
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
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>${{ number_format($subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary mt-3">Confirmar Compra</button>
    </form>
</div>
@endsection

@section('scripts')
<!-- Incluir Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Configura Stripe con tu clave pública (definida en .env)
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
    
    // Obtén referencias al select de pago y al contenedor del card element
    var paymentMethodSelect = document.getElementById('payment_method_select');
    var stripeCardContainer = document.getElementById('stripe-card-container');

    // Mostrar u ocultar el elemento de tarjeta según el método de pago seleccionado
    paymentMethodSelect.addEventListener('change', function(e) {
        if (this.value === 'tarjeta') {
            stripeCardContainer.style.display = 'block';
            // Monta el card element si aún no está montado
            cardElement.mount('#card-element');
        } else {
            stripeCardContainer.style.display = 'none';
        }
    });
    
    // Al enviar el formulario, si el método de pago es tarjeta, crea el token con Stripe.js
    var form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function(event) {
        if (paymentMethodSelect.value === 'tarjeta') {
            event.preventDefault();
            const { token, error } = await stripe.createToken(cardElement);
            if (error) {
                document.getElementById('card-errors').textContent = error.message;
            } else {
                document.getElementById('stripe_token').value = token.id;
                form.submit();
            }
        }
    });
</script>
@endsection
