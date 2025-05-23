@extends('layouts.app')

@section('title', 'Conversación con ' . $otherUser->name)

@section('content')
<div class="container">
    <h2 class="mb-4">Conversación con {{ $otherUser->name }}</h2>
    
    <div class="card mb-3">
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @foreach($messages as $message)
                <div class="mb-2">
                    <strong>{{ $message->sender_id == auth()->id() ? 'Yo' : $otherUser->name }}:</strong>
                    <p>{{ $message->content }}</p>
                    <small class="text-muted">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    
    <form action="{{ route('messages.store', $otherUser->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
    </form>
</div>
@endsection
