<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Listado de foros accesibles según el rol del usuario
    public function index(){
        $user = Auth::user();
        $forums = Forum::where('role_access', $user->role)->paginate(10);
        return view('social.forums.index', compact('forums'));
    }
    
    // Muestra el formulario para crear un nuevo foro
    public function create(){
        return view('social.forums.create');
    }
    
    // Almacena el nuevo foro asignándole automáticamente el rol del usuario creador
    public function store(Request $request){
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['user_id'] = Auth::id();
        $data['role_access'] = Auth::user()->role;
        Forum::create($data);
        return redirect()->route('forums.index')->with('success', 'Foro creado correctamente.');
    }
    
    // Visualiza un foro con sus temas
    public function show(Forum $forum){
        $user = Auth::user();
        if ($forum->role_access !== $user->role){
            abort(403, 'Acceso no autorizado a este foro.');
        }
        $forum->load('topics');
        return view('social.forums.show', compact('forum'));
    }
}
