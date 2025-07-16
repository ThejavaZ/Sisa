@extends('layout.main')

@section('top-title', "$user->name")

@section('title', "$user->name")
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('users') }}">
            Usuarios
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $user->name }}
    </li>
@endsection


@section('content')

<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a class="btn  btn-outline-danger" href="{{ route('users.pdf', $user->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="{{ route('users.docx', $user->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="{{ route('users.xlsx', $user->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a href="" class="btn btn-outline-info">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-outline-warning" href="{{ route('users.edit', $user->id) }}">
        <i class="fas fa-fw fa-edit"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-laptop me-2"></i> Información de la Computadora
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Nombre:</strong> {{ $user->name }}</p>
        <p><strong>Correo:</strong> {{ $user->email }}</p>
        <p><strong>rol:</strong> {{ $user->role == 1 ? 'Administrador' : 'Operador' }}</p>
        <p><strong>Idioma:</strong> {{ $user->languaje == 1 ? 'Español' : 'Inglés' }}</p>
        <p><strong>Activo</strong> {{ $user->active === 'S' ? 'Sí' : 'No' }}</p>
        <p><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
        <p><strong>Foto:</strong>
        @if(asset('storage/users/' . $user->id . '.png'))
            <div class="mt-3">
                <img src="{{ asset('storage/users/' . $user->id . '.png') }}" alt="Foto del empleado {{ $user->name }}" class="img-fluid rounded -ml-px w-25">
            </div>
        @else
            <div class="mt-3">
                <p class="text-muted">No hay foto disponible</p>
            </div>
        @endif
        </p>

    </div>
    <div class="card-footer text-end">
        <a href="{{ route('users') }}" class="btn btn-lg btn-secondary">
            <i class="fas fa-fw fa-arrow-left"></i>
        </a>
    </div>
</div>
@endsection
