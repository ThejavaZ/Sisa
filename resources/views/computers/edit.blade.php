@extends('layout.main')

@section('top-title', $computer->name)

@section('title', $computer->name)

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
<li class="breadcrumb-item active">editar {{ $computer->name }}</li>
@endsection

@section('content')

    @foreach ($errors->getMessages() as $field => $messages)
        @foreach ($messages as $message)
            <li>{{ $message }} (Campo: {{ $field }})</li>
        @endforeach
    @endforeach


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-computer me-1"></i>
        Editar a {{ $computer->name }}
    </div>
    <div class="card-body">
        <form action="{{ route('computers.update', $computer->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{$computer->name}}" >
            </div>

            <div class="mb-3">
                <label for="serial_number" class="form-label">Numero de serie</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" required value="{{ $computer->serial_number }}">
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label">Marca</label>
                <select name="brand_id" id="brand_id"  class="form-select">
                    <option value="" disabled selected>Seleccione una opcion</option>
                    <option value="1" {{ $computer->brand_id == "1" ? 'selected' : '' }}>HP</option>
                    <option value="2" {{ $computer->brand_id == "2" ? 'selected' : '' }}>Lenovo</option>
                    <option value="3" {{ $computer->brand_id == "3" ? 'selected' : '' }}>Framework</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="model" name="model" required value="{{ $computer->model }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="2" required>{{ $computer->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="specify" class="form-label">Especificaciones</label>
                <textarea class="form-control" id="specify" name="specify" rows="2" required>{{ $computer->specify }}</textarea>
            </div>

            <div class="mb-3">
                <label for="os" class="form-label">Sistema Operativo</label>
                <input type="text" class="form-control" id="os" name="os" required value="{{ $computer->os }}">
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">Fecha de compra</label>
                <input type="date" class="form-control" id="purchase_date" name="purchase_date" required value="{{ $computer->purchase_date }}">
            </div>

            <div class="mb-3">
                <label for="warranty_until" class="form-label">Fecha de garantia</label>
                <input type="date" class="form-control" id="warranty_until" name="warranty_until" value="{{ $computer->warranty_until }}">
            </div>

            <div class="mb-3">
                <label for="branch_id" class="form-label">Sucursal</label>
                <select name="branch_id" id="branch_id"  class="form-select">
                    <option value="" disabled selected>Seleccione una opcion</option>
                    <option value="1" {{ $computer->branch_id == "1" ? "selected" : '' }}>Hermosillo</option>
                    <option value="2" {{ $computer->branch_id == "2" ? "selected" : '' }}>Cautitlan</option>
                    <option value="3" {{ $computer->branch_id == "3" ? "selected" : '' }}>Phoenix</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="active" class="form-label">Activo</label>
                <select name="active" id="active"  class="form-select">
                    <option value="" disabled selected>Seleccione una opcion</option>
                    <option value="S" {{ $computer->active == "S" ? "selected" : '' }}>Si</option>
                    <option value="N" {{ $computer->active == "N" ? "selected" : '' }}>No</option>
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
