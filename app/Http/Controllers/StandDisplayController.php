<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandDisplayController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role === 'cliente') {
            // Invitados y clientes ven solo puestos de vendedores
            $query = Stand::whereHas('vendor', function($q) {
                $q->where('role', 'vendedor');
            });
        } elseif ($user->role === 'vendedor') {
            // Vendedores ven puestos de proveedores y vendedores
            $query = Stand::whereHas('vendor', function($q) {
                $q->whereIn('role', ['vendedor', 'proveedor']);
            });
        } elseif ($user->role === 'proveedor') {
            // Proveedores ven puestos de proveedores y vendedores
            $query = Stand::whereHas('vendor', function($q) {
                $q->whereIn('role', ['vendedor', 'proveedor']);
            });
        } else {
            $query = Stand::query();
        }
        
        $stands = $query->paginate(10);
        return view('stand.display', compact('stands', 'user'));
    }
}
