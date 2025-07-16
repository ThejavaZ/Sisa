@extends('layout.main')

@section('top-title','Editar Asignación')

@section('title', 'Editando asignación de '. $assigned->computer->name .' a '. $assigned->employee->name)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item"><a href="{{ route('assigneds') }}">Asignadas</a></li>
<li class="breadcrumb-item active">Editar</li>
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
        <i class="fas fa-edit me-1"></i>
        Editar Asignacion
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('assigneds.update', $assigned->id) }}">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="computer_id" class="form-label">Computadora</label>
                <select class="form-select" name="computer_id" id="computer_id" required>
                    <option value="">Seleccione una computadora</option>
                    @foreach($computers as $computer)
                        <option value="{{ $computer->id }}" {{ $assigned->computer_id == $computer->id ? 'selected' : '' }}>
                            {{ $computer->name }} (S/N:{{ $computer->serial_number }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="employee_id" class="form-label">Empleado</label>
                <select class="form-select" name="employee_id" id="employee_id" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $assigned->employee_id == $computer->id ? 'selected' : '' }}>
                            {{ $employee->name }} ({{ $employee->email }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Usuario</label>
                <select name="user_id" id="user_id" class="form-select">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $assigned->user_id == $user->id ? 'selected' : '' }}>{{ $user->name}} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for=" assigned_date" class="form-label">Fecha de Asignación</label>
                <input type="date" class="form-control" name=" assigned_date" id=" assigned_date" required value="{{ $assigned->assigned_date }}">
            </div>

            <div class="mb-3">
                <label for=" returned_date" class="form-label">Fecha de devolucion</label>
                <input type="date" class="form-control" name=" returned_date" id=" returned_date" value="{{ $assigned->returned_date }}">
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notas</label>
                <textarea name="notes" id="notes" rows="1" class="form-control" >{{ $assigned->notes }}</textarea>
            </div>

            <div class="mb-3">
                <label for="active" class="form-label">Activo</label>
                <select name="active" id="active" class="form-select">
                    <option value="S"{{ $assigned->active == "S" ? 'selected' : '' }}>Si</option>
                    <option value="N"{{ $assigned->active == "N" ? 'selected' : '' }}>No</option>
                </select>
            </div>

            @if (file_exists(public_path('storage/assigneds/') . $assigned->id . '.pdf'))
                <!-- Aquí puedes mostrar el enlace para ver o descargar el PDF -->
                <a href="{{ asset('storage/assigneds/' . $assigned->id . '.pdf') }}" target="_blank" class="btn btn-outline-danger">
                    <i class="fas fa-file-pdf"></i> Ver carta PDF
                </a>
            @else
                <span class="text-muted">No hay carta generada.</span>
            @endif

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
