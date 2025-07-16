@extends('layout.main')

@section('top-title','Crear Asignaciones')

@section('title', 'Asignando computadora a empleado')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item"><a href="{{ route('assigneds') }}">Asignadas</a></li>
<li class="breadcrumb-item active">Crear</li>
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
        <i class="fas fa-plus me-1"></i>
        Crear Asignación
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('assigneds.store') }}">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="computer_id" class="form-label">Computadora</label>
                <select class="form-select @error('computer_id') is-invalid @enderror" name="computer_id" id="computer_id" required>
                    <option value="">Seleccione una computadora</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}" {{ old('computer_id') == $computer->id ? 'selected' : '' }}>
                            {{ $computer->name }} ({{ $computer->serial }})
                        </option>
                    @endforeach
                </select>
                @error('computer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="employee_id" class="form-label">Empleado</label>
                <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->email }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for=" assigned_date" class="form-label">Fecha de Asignación</label>
                <input type="date" class="form-control" name=" assigned_date" id=" assigned_date" required>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notas</label>
                <textarea name="notes" id="notes" rows="1" class="form-control"></textarea>
            </div>

            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                </button>
                <a class="btn btn-secondary" href="{{ route('assigneds') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
