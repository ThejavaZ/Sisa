@extends('layout.main')

@section('top-title', 'Perfil')

@section('title', 'Usuario')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">
    Inicio
    </a>
</li>
<li class="breadcrumb-item active">Perfil</li>
@endsection

@section('content')

<div class="d-flex justify-content-around mb-4">
    <a class="btn btn-outline-dark" href="{{ route('settings') }}">
        <i class="fas fa-gear"></i>
    </a>

    <a class="btn btn-outline-warning" href="{{ route('home') }}">
        <i class="fas fa-home"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
    </div>
    <div class="card-body">
        <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Correo:</strong> {{ Auth::user()->email }}</p>
        <p><strong>rol:</strong> {{ Auth::user()->role == 1 ? 'Administrador' : 'Operador' }}</p>
        <p><strong>Idioma:</strong> {{ Auth::user()->languaje == 1 ? 'Español' : 'Inglés' }}</p>
        <p><strong>Foto:</strong>
        @if(asset('storage/users/' . Auth::user()->id . '.png'))
            <div class="mt-3">
                <img src="{{ asset('storage/users/' . Auth::user()->id . '.png') }}" alt="Foto del empleado {{ Auth::user()->name }}" class="img-fluid rounded -ml-px w-25">
            </div>
        @else
            <div class="mt-3">
                <p class="text-muted">No hay foto disponible</p>
            </div>
        @endif
        </p>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>

@endsection
