@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chat</h2>
    <div class="chat-container">
        <div class="messages">
            @foreach ($messages as $message)
            <div class="message">
                <strong>{{ $message->user->name }}:</strong>
                {{ $message->body }}
            </div>
            @endforeach
        </div>
        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="text" name="body" class="form-control" placeholder="Escribe tu mensaje...">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </span>
            </div>
        </form>
    </div>
</div>
@endsection
