<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDisplayController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Definir la consulta base según el rol
        if (!$user) {
            // Invitados: mostrar solo productos de vendedores
            $query = Product::whereHas('user', function($q) {
                $q->where('role', 'vendedor');
            });
        } elseif ($user->role === 'cliente') {
            // Clientes: ver solo productos de vendedores
            $query = Product::whereHas('user', function($q) {
                $q->where('role', 'vendedor');
            });
        } elseif ($user->role === 'vendedor') {
            // Vendedores: ver productos de proveedores y vendedores
            $query = Product::whereHas('user', function($q) {
                $q->whereIn('role', ['vendedor', 'proveedor']);
            });
        } elseif ($user->role === 'proveedor') {
            // Proveedores: ver productos de proveedores y vendedores
            $query = Product::whereHas('user', function($q) {
                $q->whereIn('role', ['vendedor', 'proveedor']);
            });
        } else {
            $query = Product::query();
        }
        
        // Filtrado por categoría
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Ordenación por precio o fecha de creación
        if ($request->filled('order_by')) {
            $orderBy = $request->order_by;
            $orderDir = $request->input('order_dir', 'asc');
            if (in_array($orderBy, ['price', 'created_at']) && in_array($orderDir, ['asc', 'desc'])) {
                $query->orderBy($orderBy, $orderDir);
            }
        }
        
        $products = $query->paginate(10);
        return view('products.display', compact('products', 'user'));
    }
}
