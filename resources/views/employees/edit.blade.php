@extends('layout.main')

@section('top-title',$employee->name)

@section('title',$employee->name)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            @if (Auth::user()->languaje == 1)
                Inicio
            @else
                Home
            @endif

        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('employees') }}">
            @if (Auth::user()->languaje == 1)
                Empleados
            @else
                Employees
            @endif
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $employee->name }}
    </li>
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
            <i class="fas fa-user-edit me-1"></i>
            @if (Auth::user()->languaje == 1)
                Editar Empleado
            @else
                Edit Employee
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $employee->name }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $employee->address }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email"  value="{{ $employee->email }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono/Celular</label>
                    <input type="text" class="form-control" id="phone" name="phone"  value="{{ $employee->phone }}">
                </div>


                <div class="mb-3">
                    <label for="position_id" class="form-label">Puesto</label>
                    <select class="form-select" id="position_id" name="position_id" required>
                        <option value="">Seleccione un puesto</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}"
                                {{ $employee->position_id === $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="active" class="form-label">Activo</label>
                    <select class="form-select" id="active" name="active" required>
                        <option value="S" {{ $employee->active === 'S' ? 'selected' : '' }}>Si</option>
                        <option value="N" {{ $employee->active === 'N' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" value="{{asset('storage/employees/' .  $employee->id . '.png') }}">
                    @if(asset('storage/employees/' .  $employee->id . '.png'))
                        <img src="{{ asset('storage/employees/' .  $employee->id . '.png') }}" alt="Foto del Empleado" class="img-fluid mt-2 rounded w-25">
                    @else
                        <p class="text-muted mt-2">No hay foto disponible</p>
                    @endif
                </div>

                @if (asset('storage/employees/' . $employee->id . '.png'))
                    <div class="mb-3">
                        <label class="form-label">Borrar Foto</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete_image" name="delete_image">
                            <label class="form-check-label" for="delete_image">Eliminar foto actual</label>
                        </div>
                    </div>
                @endif

            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                </button>


                <a class="btn btn-secondary" href="{{ route('employees') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            </form>

    </div>
@endsection
