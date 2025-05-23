<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Muestra el contenido del carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
    
    // Agrega un producto al carrito
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
        
        // Si el producto ya está en el carrito, se actualiza la cantidad
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id'          => $product->id,
                'name'        => $product->name,
                'price'       => $product->price,
                'quantity'    => $quantity,
                'stock'       => $product->stock,
                'vendor_id'   => $product->user_id,
                'image'       => $product->image ?? null,
            ];
        }
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }
    
    // Actualiza la cantidad de un producto en el carrito
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $quantity = (int)$request->input('quantity', 1);
            // Evita cantidades negativas o cero
            $cart[$id]['quantity'] = max($quantity, 1);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cantidad actualizada.');
        }
        return redirect()->back()->with('error', 'Producto no encontrado en el carrito.');
    }
    
    // Elimina un producto del carrito
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Producto eliminado del carrito.');
        }
        return redirect()->back()->with('error', 'Producto no encontrado.');
    }
}
