@extends('layout.main')

@section('top-title', $position->name)

@section('title', $position->name)

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('positions') }}">Puestos</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $position->name }}
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
        <i class="fas fa-sitemap me-1"></i>
        {{ $position->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('positions.update', $position->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ $position->name }}">
            </div>

            <div class="mb-3">
                <label for="level" class="form-label">Nivel</label>
                <select class="form-select" name="level">
                    <option value="">Selecciona una opcion</option>
                    <option value="1" {{ $position->level == 1 ? 'selected' : '' }}>Administrativo</option>
                    <option value="2" {{ $position->level == 2 ? 'selected' : '' }}>Operativo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Departamento</label>
                <select name="department_id" id="department_id" class="form-select">
                    <option value="">Selecciona una opcion</option>
                    <option value="1" {{ $position->department_id == 1 ? 'selected' : '' }}>Administracion</option>
                    <option value="2" {{ $position->department_id == 2 ? 'selected' : '' }}>Operativo</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="2">{{ $position->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salario</label>
                <input type="number" class="form-control" id="salary" name="salary" required value="{{ $position->salary }}">
            </div>

            <div class="mb-3">
                <label for="active" class="form-label">Activo</label>
                <select type="number" class="form-control" id="active" name="active" required>
                    <option value="S" {{ $position->active === 'S' ? 'selected' : '' }}>Si</option>
                    <option value="N" {{ $position->active === 'N' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                </button>


                <a class="btn btn-secondary" href="{{ route('positions') }}">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
