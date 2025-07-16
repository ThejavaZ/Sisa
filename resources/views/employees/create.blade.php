@extends('layout.main')

@section('top-title', 'Crear Empleado')

@section('title', 'Crear Empleado')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('employees') }}">Empleados</a></li>
    <li class="breadcrumb-item active">Crear Empleado</li>
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
            <i class="fas fa-user-plus me-1"></i>
            Crear Empleado
        </div>
        <div class="card-body">
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <fieldset>
                    <legend class="form-legend">Nombre</legend>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre(s)</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="first_lastname" class="form-label">Apellido paterno</label>
                        <input type="text" class="form-control" id="first_lastname" name="first_lastname" placeholder="Apellido paterno del empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="seccond_lastname" class="form-label">Apellido materno</label>
                        <input type="text" class="form-control" id="seccond_lastname" name="seccond_lastname" placeholder="Apellido paterno del empleado" required>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>

                    <div class="mb-3">
                        <label for="street" class="form-label">Calle</label>
                        <input type="text" class="form-control" id="street" name="street" placeholder="Calle" required>
                    </div>

                    <div class="mb-3">
                        <label for="interior_number " class="form-label">Numero interior</label>
                        <input type="text" class="form-control" id="interior_number " name="interior_number " placeholder="Numero interior">
                    </div>

                    <div class="mb-3">
                        <label for="exterior_number " class="form-label">Numero exterior</label>
                        <input type="text" class="form-control" id="exterior_number " name="exterior_number " placeholder="Numero exterior" required>
                    </div>

                    <div class="mb-3">
                        <label for="colony " class="form-label">Colonia</label>
                        <input type="text" class="form-control" id="colony " name="colony " placeholder="Direccion del empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="zip_code " class="form-label">Codigo postal</label>
                        <input type="text" class="form-control" id="zip_code " name="zip_code " placeholder="Direccion del empleado" required>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Informacion personal</legend>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo electronico" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono/Celular</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Numero celular" required>
                    </div>

                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Fecha de cumpleaños</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Genero</label>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">Selecciona una opcion</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="RFC" class="form-label">RFC</label>
                        <input type="text" class="form-control" name="RFC" id="RFC" placeholder="RFC del empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="curp" class="form-label">CURP</label>
                        <input type="text" class="form-control" name="curp" id="curp" placeholder="CURP del empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="NSS" class="form-label">NSS</label>
                        <input type="text" class="form-control" name="NSS" id="NSS" placeholder="Numero de seguro social" required>
                    </div>

                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Numero de emergencia</label>
                        <input type="text" class="form-control" name="emergency_contact" id="emergency_contact" placeholder="Numero de emergencia" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                </fieldset>

                <fieldset>
                    <legend>Informacion laboral</legend>

                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Fecha de entrada</label>
                        <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Sucursal</label>
                        <select name="branch_id" id="branch_id" class="form-select" required>
                            <option value="1">Hermosillo</option>
                            <option value="2">Cautitlan</option>
                            <option value="3">Phoenix</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="position_id" class="form-label">Puesto</label>
                        <select class="form-select" id="position_id" name="position_id" required>
                            <option value="">Seleccione un puesto</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>

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
