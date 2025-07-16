@extends('layout.main')

@section('top-title','Creando Usuario')

@section('title', 'Creando Usuario')

@section('breadcrumb')

@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user me-1"></i>
        Registrar nuevo usuario
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Seleccione un rol</option>
                        <option value="1">Administrador</option>
                        <option value="2">Operador</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="language" class="form-label">Idioma</label>
                <select class="form-select" id="language" name="language" required>
                    <option value="">Seleccione un Idioma</option>
                        <option value="1">Español</option>
                        <option value="2">Inglés</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Foto</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                </button>


                <a class="btn btn-secondary" href="{{ route('users') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
