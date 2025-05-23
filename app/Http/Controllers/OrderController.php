<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Constructor para aplicar middleware de autenticación.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Muestra el listado de pedidos para el usuario autenticado.
     * Opcional: Este método puede personalizarse según el rol.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'cliente') {
            // El cliente ve solo sus pedidos
            $orders = Order::where('client_id', $user->id)->paginate(10);
        } elseif ($user->role === 'vendedor') {
            // El vendedor ve los pedidos realizados a él
            $orders = Order::where('vendor_id', $user->id)->paginate(10);
        } else {
            // Para otros roles (por ejemplo, proveedor), se puede ajustar la lógica
            $orders = Order::paginate(10);
        }
        
        return view('order.index', compact('orders'));
    }
    
    /**
     * Muestra los detalles de un pedido específico.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga permiso para ver el pedido.
        if ($order->seller_id !== $user->id && $order->buyer_id !== $user->id) {
            abort(403, 'Acceso no autorizado.');
        }
        
        
        // Si existe lógica adicional para proveedores, se debe agregar aquí.
        // Cargar relaciones necesarias (por ejemplo, items y cada producto)
        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Muestra el formulario para editar un pedido.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        $user = Auth::user();
        
        // Verifica que el vendedor tenga permiso para editar el pedido
        if ( $order->seller_id !== $user->id) {
            abort(403, 'Acceso no autorizado.');
        }
        
        // Cargar relaciones necesarias (por ejemplo, items y cada producto)
        $order->load('items.product');
        
        return view('orders.edit', compact('order'));
    }
    
    /**
     * Actualiza la información del pedido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $user = Auth::user();
        
        // Verifica nuevamente el permiso
        if ($order->seller_id !== $user->id) {
            abort(403, 'Acceso no autorizado.');
        }
        
        // Validar datos de actualización; aquí se permite editar dirección de envío,
        // método de pago y estado del pedido.
        $data = $request->validate([
            'status'           => 'required|in:pendiente,procesando,enviado,entregado,cancelado',
        ]);
        
        $order->update($data);
        
        return redirect()->route('order.show', $order->id)
                         ->with('success', 'Pedido actualizado correctamente.');
    }
}

