<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Listado de conversaciones activas del usuario autenticado
    public function index()
    {
        $user = Auth::user();
        // Obtener mensajes donde el usuario es sender o receiver
        $conversations = Message::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->orderBy('created_at', 'desc')->get()->groupBy(function ($message) use ($user) {
            // Agrupar por el id del otro usuario
            return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
        });
        
        $conversationUsers = [];
        foreach ($conversations as $otherUserId => $messages) {
            $otherUser = User::find($otherUserId);
            if ($otherUser) {
                $conversationUsers[] = [
                    'user' => $otherUser,
                    'messages' => $messages,
                    'unread' => $messages->where('receiver_id', $user->id)->whereNull('read_at')->count(),
                ];
            }
        }
        
        return view('social.messages.index', compact('conversationUsers'));
    }
    
    // Vista de mensajes entre dos usuarios
    public function show($receiverId)
    {
        $user = Auth::user();
        $messages = Message::where(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('sender_id', $receiverId)
              ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();
        
        // Marcar como leídos los mensajes donde el receptor es el usuario autenticado
        Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        $otherUser = User::findOrFail($receiverId);
        return view('social.messages.show', compact('messages', 'otherUser'));
    }
    
    // Envío de mensajes
    public function store(Request $request, $receiverId)
    {
        $user = Auth::user();
        $data = $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        User::findOrFail($receiverId);
        Message::create([
            'sender_id'   => $user->id,
            'receiver_id' => $receiverId,
            'content'     => $data['content'],
        ]);
        return redirect()->route('messages.show', $receiverId)
                         ->with('success', 'Mensaje enviado.');
    }
    
    // Listado de usuarios para iniciar una nueva conversación
    public function users()
    {
        $user = Auth::user();
        $users = User::where('id', '!=', $user->id)->get();
        return view('social.messages.users', compact('users'));
    }
}
