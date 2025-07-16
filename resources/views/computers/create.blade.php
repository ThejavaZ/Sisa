@extends('layout.main')

@section('top-title', 'creando computadora')

@section('title', 'Creando Computadora')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">
    Inicio
    </a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('computers') }}">
    Computadoras
    </a>
</li>
<li class="breadcrumb-item active">Creando computadora</li>
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
        <i class="fas fa-computer me-1"></i>
        Registrar nueva computadora
    </div>
    <div class="card-body">
        <form action="{{ route('computers.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre de la computadora" required>
            </div>

            <div class="mb-3">
                <label for="serial_number" class="form-label">Numero de serie</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Ingrese el numero de serie S/N" required>
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label">Marca</label>
                <select name="brand_id" id="brand_id"  class="form-select">
                    <option value="" disabled selected>Seleccione una opcion</option>
                    <option value="1">HP</option>
                    <option value="2">Lenovo</option>
                    <option value="3">Framework</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model" name="model" placeholder="Ingrese el modelo" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="2" placeholder="Ingrese la descripcion y area" required></textarea>
            </div>

            <div class="mb-3">
                <label for="specify" class="form-label">Especificaciones</label>
                <textarea class="form-control" id="specify" name="specify" rows="2" placeholder="Ingrese el procesador, memoria RAM, memoria integrada, etc." required></textarea>
            </div>

            <div class="mb-3">
                <label for="os" class="form-label">Sistema Operativo</label>
                <input type="text" class="form-control" id="os" name="os" placeholder="Ingrese el sistema operativo" required>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">Fecha de compra</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
            </div>

            <div class="mb-3">
                <label for="warranty_until" class="form-label">Fecha de garantia</label>
                <input type="date" class="form-control" id="warranty_until" name="warranty_until" required>
            </div>

            <div class="mb-3">
                <label for="branch_id" class="form-label">Sucursal</label>
                <select name="branch_id" id="branch_id"  class="form-select">
                    <option value="" disabled selected>Seleccione una opcion</option>
                    <option value="1">Hermosillo</option>
                    <option value="2">Cautitlan</option>
                    <option value="3">Phoenix</option>
                </select>
            </div>

            <div class="d-flex flex-row justify-content-around">
                <button type="submit" class="btn btn-lg btn-primary">
                    <i class="fas fa-fw fa-save"></i>
                </button>


                <a class="btn btn-lg btn-secondary" href="{{ route('computers') }}">
                    <i class="fas fa-fw fa-arrow-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
