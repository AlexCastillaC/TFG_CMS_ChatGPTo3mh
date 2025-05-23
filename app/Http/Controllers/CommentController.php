<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function store(Request $request, Forum $forum, Topic $topic)
{
    $data = $request->validate([
        'content' => 'required|string',
    ]);

    $data['topic_id'] = $topic->id;
    $data['user_id']  = Auth::id();

    Comment::create($data);

    return redirect()->route('topics.show', [$forum->id, $topic->id])
                     ->with('success', 'Comentario añadido.');
}

}
