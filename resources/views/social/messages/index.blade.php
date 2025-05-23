@extends('layouts.app')

@section('title', 'Mensajes Privados')

@section('content')
<div class="container">
    <h2 class="mb-4">Conversaciones</h2>
    @if(count($conversationUsers) > 0)
        <ul class="list-group">
            @foreach($conversationUsers as $conversation)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('messages.show', $conversation['user']->id) }}">
                        {{ $conversation['user']->name }}
                    </a>
                    @if($conversation['unread'] > 0)
                        <span class="badge badge-primary badge-pill">{{ $conversation['unread'] }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No tienes conversaciones activas.</p>
    @endif
    <a href="{{ route('messages.users') }}" class="btn btn-secondary mt-3">Iniciar Nueva Conversación</a>
</div>
@endsection
