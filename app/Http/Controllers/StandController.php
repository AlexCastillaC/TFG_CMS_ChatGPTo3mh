<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Permite el acceso únicamente a vendedores y proveedores
        $this->middleware('checkRole:vendedor,proveedor');
    }
    
    // Si el usuario ya tiene un puesto, lo muestra; de lo contrario redirige a create.
    public function index()
    {
        $stand = Stand::where('user_id', Auth::id())->first();
        if ($stand) {
            return redirect()->route('stand.show', $stand->id);
        } else {
            return redirect()->route('stand.create');
        }
    }
    
    // Muestra el formulario para crear un nuevo puesto.
    public function create()
    {
        // Si ya existe un puesto, redirige al formulario de edición.
        $stand = Stand::where('user_id', Auth::id())->first();
        if ($stand) {
            return redirect()->route('stand.edit', $stand->id);
        }
        return view('stand.create');
    }
    
    // Guarda el nuevo puesto en la base de datos.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'location'     => 'required|string|max:255',
            'category'     => 'nullable|string|max:255',
            'stand_picture'=> 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('stand_picture')) {
            $file = $request->file('stand_picture');
            $path = $file->store('stands', 'public');
            $data['stand_picture'] = $path;
        }
        
        $data['user_id'] = Auth::id();
        $stand = Stand::create($data);
        
        return redirect()->route('stand.show', $stand->id)
                         ->with('success', 'Puesto creado correctamente.');
    }
    
    // Muestra los detalles del puesto.
    public function show($id)
    {
        $stand = Stand::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        return view('stand.show', compact('stand'));
    }
    
    // Muestra el formulario para editar el puesto.
    public function edit($id)
    {
        $stand = Stand::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        return view('stand.edit', compact('stand'));
    }
    
    // Actualiza la información del puesto.
    public function update(Request $request, $id)
    {
        $stand = Stand::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
                      
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'location'     => 'required|string|max:255',
            'category'     => 'nullable|string|max:255',
            'stand_picture'=> 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('stand_picture')) {
            // Elimina la imagen antigua si existe y está almacenada en el disco "public"
            if ($stand->stand_picture && Storage::disk('public')->exists($stand->stand_picture)) {
                Storage::disk('public')->delete($stand->stand_picture);
            }
            
            $file = $request->file('stand_picture');
            $path = $file->store('stands', 'public');
            $data['stand_picture'] = $path;
        }
        
        $stand->update($data);
        
        return redirect()->route('stand.show', $stand->id)
                         ->with('success', 'Puesto actualizado correctamente.');
    }
    
    // Elimina el puesto.
    public function destroy($id)
    {
        $stand = Stand::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();
        $stand->delete();
        
        return redirect()->route('stand.create')
                         ->with('success', 'Puesto eliminado correctamente.');
    }
}
