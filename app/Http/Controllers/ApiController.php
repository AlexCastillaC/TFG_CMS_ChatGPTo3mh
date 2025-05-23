<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    /**
     * Endpoint para obtener el clima de San Mateo, Gran Canaria.
     * Utiliza caché de 30 minutos para evitar llamadas excesivas.
     */
    public function clima()
{
    $cacheKey = 'clima_san_mateo';
    $clima = Cache::remember($cacheKey, 1800, function () {
        try {
            $url = "http://api.openweathermap.org/data/2.5/weather";
            $apiKey = env('OPENWEATHERMAP_KEY');
            $response = Http::get("http://api.openweathermap.org/data/2.5/weather?q=San%20Mateo,ES&appid=91cef7f7d40209dd422d53a28f69d547&units=metric&lang=es");
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'temperature' => $data['main']['temp'],
                    'condition'   => $data['weather'][0]['description'],
                    'humidity'    => $data['main']['humidity'],
                    'wind_speed'  => $data['wind']['speed'],
                ];
            } else {
                \Log::error('Error en OpenWeatherMap API: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Excepción al obtener el clima: ' . $e->getMessage());
        }
        return null;
    });

    if (!$clima) {
        return response()->json(['error' => 'No se pudo recuperar la información del clima'], 500);
    }
    return response()->json($clima);
}

    
    /**
     * Endpoint para obtener productos destacados.
     * Se asume que los productos destacados son aquellos con is_featured true o se pueden ordenar por created_at.
     */
    public function featuredProducts()
    {
        $featured = Product::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->with('user') // incluir información del usuario (por ejemplo, para filtrar según rol)
            ->get();
        
        return response()->json($featured);
    }
    
    /**
     * Endpoint para buscar productos.
     * Se recibe un parámetro "q" en la solicitud.
     */
    public function productSearch(Request $request)
    {
        $q = $request->input('q', '');
        $results = Product::where('is_available', true)
            ->where(function($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%")
                      ->orWhere('description', 'LIKE', "%{$q}%");
            })
            ->with('user')
            ->get();
            
        return response()->json($results);
    }
    
    /**
     * Endpoint para obtener información de usuarios (opcional para la API interna)
     */
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }
    
    /**
     * Endpoint para obtener puestos.
     */
    public function stands()
    {
        $stands = Stand::with('user')->get();
        return response()->json($stands);
    }
}
