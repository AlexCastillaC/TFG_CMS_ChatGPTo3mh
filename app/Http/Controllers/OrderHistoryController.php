<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();

        // Pedidos encargados por el usuario: donde él es comprador.
        $buyerOrders = Order::where('buyer_id', $user->id)->get();

        // Si el usuario tiene rol vendedor o proveedor, se mostrarán también los pedidos encargados a él.
        $sellerOrders = null;
        if (in_array($user->role, ['vendedor', 'proveedor'])) {
            $sellerOrders = Order::where('seller_id', $user->id)->get();
        }
        
        return view('orders.history', compact('buyerOrders', 'sellerOrders'));
    }
}
