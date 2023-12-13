@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Chats</h2>
    <ul>
        @foreach ($chats as $chat)
        <li><a href="{{ route('chats.show', $chat->id) }}">{{ $chat->name }}</a></li>
        @endforeach
    </ul>
</div>


<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Portal With Twilio</title>
    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="jumbotron">

            @if(session('status') === true)
                <div class="alert alert-success">
                    El estado es verdadero.
                </div>
            @elseif(session('status') === false)
                <div class="alert alert-danger">
                    El estado es falso.
                </div>
            @endif


            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Add Phone Number
            </div>
            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Enter Phone Number</label>
                        <input type="tel" class="form-control" name="phone_number" placeholder="Enter Phone Number">
                    </div>
                    <button type="submit" class="btn btn-primary">Register User</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                Select Message Type
            </div>
            <div class="card-body">
                <form method="POST" id="messageForm" action="{{ route('chat.send') }}">
                    @csrf

                    <div class="form-group">
                        <label>Select Message Type</label>
                        <select name="message_type" id="messageType" class="form-control" onchange="mostrarCampo(this.value)">
                            <option value="Texto">Texto</option>
                            <option value="Imagen">Imagen</option>
                            <option value="Pdf">Pdf</option>
                            <option value="Template">Template</option>
                            <option value="Ubicación">Ubicación</option>
                            <option value="Contactos">Contactos</option>
                            <option value="Interactivos">Interactivos</option>

                        </select>
                    </div>

                    <div id="campoTexto" style="display: none;">
                        <label for="texto">Texto:</label>
                        <input type="text" name="texto" id="texto" class="form-control">
                    </div>

                    <div id="campoMultimedia" style="display: none;">
                        <label for="archivo">Seleccionar archivo:</label>
                        <input type="file" name="archivo" id="archivo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Select users to notify</label>
                        <select name="users" multiple class="form-control">
                            @foreach ($users as $user)
                            <option value="{{ $user->phone_number }}">{{ $user->phone_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarCampo(opcion) {
        document.getElementById('campoTexto').style.display = 'none';
        document.getElementById('campoMultimedia').style.display = 'none';

        if (opcion === 'Texto') {
            document.getElementById('campoTexto').style.display = 'block';
        } else if (opcion === 'Contenido multimedia') {
            document.getElementById('campoMultimedia').style.display = 'block';
        }
        // Agrega más condiciones para otras opciones
    }
</script>
</body>
</html>

@endsection
