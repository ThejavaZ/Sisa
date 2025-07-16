@extends('layout.main')

@section('top-title',  $assigned->id )

@section('title', 'Asignada #' . $assigned->id)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assigneds') }}">Asignadas</a></li>
    <li class="breadcrumb-item active">{{ $assigned->id }}</li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-outline-danger" href="{{ route('assigneds') }}" target="_blank">
        <i class="fas fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="{{ route('assigneds') }}" target="_blank">
        <i class="fas fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="{{ route('assigneds') }}" target="_blank">
        <i class="fas fa-file-excel"></i>
    </a>
    <a href="" class="btn btn-outline-info">
        <i class="fas fa-envelope"></i>
    </a>
    <a class="btn btn-outline-warning" href="{{ route('assigneds.edit', $assigned->id) }}">
        <i class="fas fa-edit"></i>
    </a>
</div>

<div class="card mb-4 shadow">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="fas fa-file me-2"></i>
        <span>Información de la asignacion</span>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-6"><strong>ID:</strong> {{ $assigned->id }}</div>
            <div class="col-md-6"><strong>Computadora:</strong> {{ $assigned->computer->name }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Empleado:</strong> {{ $assigned->employee->name }}</div>
            <div class="col-md-6"><strong>Usuario:</strong> {{ $assigned->user->name }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Fecha de asignación:</strong> {{ $assigned->assigned_date }}</div>
            <div class="col-md-6">
                @if ($assigned->returned_date)
                    <strong>Fecha de regreso:</strong> {{ $assigned->returned_date }}
                @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Activo:</strong> {{ $assigned->active === 'S' ? 'Sí' : 'No' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Creado:</strong> {{ $assigned->created_at->format('d/m/Y H:i') }}</div>
            <div class="col-md-6"><strong>Actualizado:</strong> {{ $assigned->updated_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="mt-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-sticky-note me-2"></i>Notas
                </div>
                <div class="card-body">
                    {{ $assigned->notes ?? 'Sin notas.' }}
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="" class="btn btn-outline-danger me-2">
                <i class="fas fa-file"></i>
            </a>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('assigneds') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>
@endsection
