@extends('layout.main')

@section('top-title', $position->name)

@section('title', $position->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('positions') }}">Puestos</a></li>
    <li class="breadcrumb-item active">{{ $position->name}}</li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-lg btn-outline-danger" href="{{ route('positions.pdf', $position->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>

    <a class="btn btn-lg btn-outline-primary" href="{{ route('positions.docx', $position->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>

    <a class="btn btn-lg btn-outline-success" href="{{ route('positions.xlsx', $position->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>

    <a class="btn btn-lg btn-outline-info" href="{{ route('positions.email', $position->id) }}">
        <i class="fas fa-fw fa-envelope"></i>
    </a>

    <a class="btn btn-lg btn-outline-warning" href="{{ route('positions.edit', $position->id) }}">
        <i class="fas fa-fw fa-edit"></i>
    </a>
</div>

<div class="card mb-4 shadow">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="fas fa-sitemap me-2"></i>
        <span>{{ $position->name }}</span>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <p><strong>ID:</strong> {{ $position->id }}</p>
            <p><strong>Nombre:</strong> {{ $position->name }}</p>
            <p><strong>Nivel:</strong>
                @if ($position->level == 1)
                    Administrativo
                @elseif ($position->level == 2)
                    Operativo
                @elseif ($position->level == 3)
                    Supervicion/Cordinacion
                @elseif ($position->level == 4)
                    Direccion/Gerencia
                @else
                    desconocido
                @endif
            </p>
            <p><strong>Departamento:</strong> {{ $position->department_id }}</p>
            <p><strong>Salario:</strong> {{ $position->salary }}</p>
            <p><strong>Activo:</strong> {{ $position->active === 'S' ? 'Sí' : 'No' }}</p>
            <p><strong>Creado:</strong> {{ $position->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Actualizado:</strong> {{ $position->updated_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mt-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-sticky-note me-2"></i>Descripcion
                </div>
                <div class="card-body">
                    {{ $position->description ?? 'Sin descripcion.' }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('positions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>

@endsection
