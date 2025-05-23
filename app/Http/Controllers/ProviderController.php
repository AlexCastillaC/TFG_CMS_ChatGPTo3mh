<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    // Mostrar perfil del proveedor
    public function profile()
    {
        $user = Auth::user();
        return view('provider.profile', compact('user'));
    }

    // Actualizar perfil del proveedor
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_picture'=> 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Elimina la imagen antigua si existe y está almacenada en el disco "public"
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        $user->update($data);
        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
    
    // Métodos adicionales para gestionar stand, productos y pedidos se pueden agregar aquí o en controladores dedicados.
}
