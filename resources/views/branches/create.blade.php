@extends('layout.main')

@section('top-title', 'Creando sucursal')

@section('title', 'Creando sucursal')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('branches') }}">Sucursales</a>
    </li>
    <li class="breadcrumb-item active">
        Creando sucursal
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
            <i class="fas fa-shop me-1"></i>
            Registrar nueva sucursal
        </div>
        <div class="card-body">
            <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Calle</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Numero interior</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Numero exterior</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Colonia</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Codigo postal</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>

                <div class="d-flex flex-row justify-content-around">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                    </button>


                    <a class="btn btn-secondary" href="{{ route('users') }}">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
