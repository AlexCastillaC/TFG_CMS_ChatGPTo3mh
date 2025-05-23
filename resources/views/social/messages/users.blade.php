@extends('layouts.app')

@section('title', 'Iniciar Conversación')

@section('content')
<div class="container">
    <h2 class="mb-4">Usuarios Disponibles</h2>
    <ul class="list-group">
        @foreach($users as $userItem)
            <li class="list-group-item">
                <a href="{{ route('messages.show', $userItem->id) }}">{{ $userItem->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
