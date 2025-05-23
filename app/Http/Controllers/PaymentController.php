<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Muestra el formulario de pago.
     */
    public function showPaymentForm()
    {
        return view('payment.form');
    }
    
    /**
     * Procesa el pago utilizando Stripe Cashier.
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string', // token generado por Stripe.js
            // Agrega más validaciones según sea necesario
        ]);
        
        $user = Auth::user();
        
        try {
            // Realiza un cargo único (por ejemplo, $10.00, que se expresa en centavos)
            $user->charge(1000, $request->payment_method);
            
            return redirect()->back()->with('success', 'Pago realizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error en el pago: ' . $e->getMessage());
        }
    }
    
    /**
     * Webhook para recibir notificaciones de Stripe (opcional, para manejo de eventos).
     */
    public function handleWebhook(Request $request)
    {
        // Usa Cashier para procesar el webhook de Stripe
        return \Laravel\Cashier\Http\Controllers\WebhookController::handleWebhook($request);
    }
}
