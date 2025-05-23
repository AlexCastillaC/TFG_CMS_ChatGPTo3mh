<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole:proveedor');
    }
    
    public function index(Request $request)
    {
        $query = Product::where('user_id', Auth::id());
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('availability')) {
            $availability = $request->availability === 'true';
            $query->where('is_available', $availability);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%");
            });
        }
        if ($request->filled('order_by')) {
            $orderBy = $request->order_by;
            $orderDir = $request->input('order_dir', 'asc');
            if (in_array($orderBy, ['price', 'created_at']) && in_array($orderDir, ['asc', 'desc'])) {
                $query->orderBy($orderBy, $orderDir);
            }
        }
        
        $products = $query->paginate(10);
        
        return view('provider.products.index', compact('products'));
    }

    public function show($id)
{
    // Se obtiene el producto que pertenece al usuario autenticado
    $product = Product::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail(); // Asegúrate de ejecutar la consulta;
    
    // Retorna la vista con los detalles del producto
    return view('provider.products.show', compact('product'));
}
    
    public function create()
    {
        return view('provider.products.create');
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
            'category'     => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
        ]);
        
        $data['user_id'] = Auth::id();

        $data['user_id'] = Auth::id();
        if(Auth::user()->stand){
            $data['stand_id'] = Auth::user()->stand->id;
        }
        
        Product::create($data);
        
        return redirect()->route('provider.products.index')
                         ->with('success', 'Producto creado correctamente.');
    }
    
    public function edit($id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        return view('provider.products.edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
            'category'     => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
        ]);
        
        $product->update($data);
        
        return redirect()->route('provider.products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }
    
    public function destroy($id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        $product->delete();
        
        return redirect()->route('provider.products.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
    
    public function updateStock(Request $request, $id)
    {
        $product = Product::where('id', $id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        
        $data = $request->validate([
            'stock' => 'required|integer|min:0'
        ]);
        
        $product->update($data);
        
        return redirect()->route('provider.products.index')
                         ->with('success', 'Stock actualizado correctamente.');
    }
}
