<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    // Muestra el formulario para crear un tema en un foro
    public function create(Forum $forum){
        if ($forum->role_access !== Auth::user()->role){
            abort(403, 'Acceso no autorizado.');
        }
        return view('social.topics.create', compact('forum'));
    }
    
    // Almacena el nuevo tema
    public function store(Request $request, Forum $forum){
        if ($forum->role_access !== Auth::user()->role){
            abort(403, 'Acceso no autorizado.');
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $data['forum_id'] = $forum->id;
        $data['user_id'] = Auth::id();
        Topic::create($data);
        return redirect()->route('forums.show', $forum->id)->with('success', 'Tema creado correctamente.');
    }
    
    // Visualiza un tema con sus comentarios
    public function show(Forum $forum, Topic $topic){
        if ($topic->forum_id != $forum->id){
            abort(404, 'Tema no encontrado en este foro.');
        }
        $topic->load('comments');
        return view('social.topics.show', compact('forum', 'topic'));
    }
}
