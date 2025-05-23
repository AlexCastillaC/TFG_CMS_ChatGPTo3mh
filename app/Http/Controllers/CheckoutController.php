<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Muestra el formulario de checkout
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }
        return view('checkout.index', compact('cart'));
    }
    
    // Procesa el checkout
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method'   => 'required|string', // Se podría validar contra métodos disponibles
        ]);
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'El carrito está vacío.');
        }
        
        // Verificar stock de cada producto
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "El producto {$item['name']} no tiene stock suficiente.");
            }
        }
        
        // Inicia una transacción para crear el pedido y actualizar stock
        DB::beginTransaction();
        try {
            // En este ejemplo se asume un único vendedor por pedido.
            // En caso de productos de diferentes vendedores, se debería agrupar y crear múltiples pedidos.
            // Se toma el primer vendedor encontrado:
            $vendorId = current($cart)['vendor_id'];
            
            // Crear el pedido
            $order = Order::create([
                'buyer_id'        => Auth::id(),
                'seller_id'        => $vendorId,
                'total'            => array_reduce($cart, function ($carry, $item) {
                                        return $carry + ($item['price'] * $item['quantity']);
                                    }, 0),
                'status'           => 'pendiente',
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'pendiente',
                'shipping_address' => $request->shipping_address,
            ]);
            
            // Crear cada item de pedido y actualizar stock
            foreach ($cart as $item) {
                $product = Product::find($item['id']);
                // Crear el item
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);
                // Actualizar stock del producto
                $product->decrement('stock', $item['quantity']);
            }
            
            DB::commit();
            // Limpiar el carrito
            session()->forget('cart');
            return redirect()->route('order.show', $order->id)
                             ->with('success', 'Pedido realizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                             ->with('error', 'Error en el proceso de compra: ' . $e->getMessage());
        }
    }
}
