@extends('layout.main')

@section('top-title',$employee->name)

@section('title', $employee->name)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('employees') }}">
            Empleados
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $employee->name }}
    </li>
@endsection

@section('content')
<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a class="btn btn-outline-danger" href="{{ route('employees.pdf', $employee->id) }}" target="_blank">
        <i class="fas fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="{{ route('employees.docx', $employee->id) }}" target="_blank">
        <i class="fas fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="{{ route('employees.xlsx', $employee->id) }}" target="_blank">
        <i class="fas fa-file-excel"></i>
    </a>

    <a href="{{ route('employees.email', $employee->id) }}" class="btn btn-outline-info">
        <i class="fas fa-envelope"></i>
    </a>

    <a class="btn btn-outline-warning" href="{{ route('employees.edit', $employee->id) }}">
        <i class="fas fa-edit"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-user me-2"></i> Información del Empleado
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $employee->id }}</p>
        <p><strong>Nombre:</strong> {{ $employee->name }}</p>
        <p><strong>Dirección:</strong> {{ $employee->address }}</p>
        <p><strong>Teléfono/Celular:</strong> {{ $employee->phone }}</p>
        <p><strong>Fecha de entrada:</strong> {{ $employee->hire_date }}</p>
        <p><strong>Fecha de cumpleaños:</strong> {{ $employee->birth_date }}</p>
        <p><strong>Genero:</strong>
        @if ($employee->gender == "M")
            Masculino
        @elseif ($employee->gender == "F")
            Femenino
        @else
            Otro
        @endif
        </p>
        <p><strong>RFC:</strong> {{ $employee->RFC }}</p>
        <p><strong>Puesto:</strong> {{ $employee->position ? $employee->position->name : 'No asignado' }}</p>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Activo:</strong> {{ $employee->active === 'S' ? 'Sí' : 'No' }}</p>
        <p><strong>Creado:</strong> {{ $employee->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Actualizado:</strong> {{ $employee->updated_at->format('d/m/Y H:i') }}</p>

        @if(asset('storage/employees/' . $employee->id . '.png'))
            <div class="mt-3">
                <img src="{{ asset('storage/employees/' . $employee->id . '.png') }}" alt="Foto del empleado {{ $employee->name }}" class="img-fluid rounded -ml-px w-25">
            </div>
        @else
            <div class="mt-3">
                <p class="text-muted">No hay foto disponible</p>
            </div>
        @endif
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('employees') }}" class="btn btn-lg btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>
@endsection
