@extends('layout.main')

@section('top-title','Empleados')

@section('title','Empleados')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active">
        Empleados
    </li>
@endsection

@section('content')

<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a class="btn btn-outline-danger" href="{{ route('employees.pdf') }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="{{ route('employees.docx') }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="{{ route('employees.xlsx') }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a href="" class="btn btn-outline-info">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-outline-warning" href="{{ route('employees.create') }}">
        <i class="fas fa-fw fa-plus"></i>
    </a>
</div>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-users me-1"></i>
        Empleados
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Dirrección</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Fecha de contratacion</th>
                    <th>Fecha de cumpleaños</th>
                    <th>Genero</th>
                    <th>RFC</th>
                    <th>curp</th>
                    <th>NSS</th>
                    <th>Sucursal</th>
                    <th>Contacto de emergencia</th>
                    <th>Puesto</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado por</th>
                    <th>Actualizado por</th>
                    <th>Cancelado por</th>
                    <th>Eliminado por</th>
                    @endif
                    <th>Activo</th>
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Dirrección</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Fecha de contratacion</th>
                    <th>Fecha de cumpleaños</th>
                    <th>Genero</th>
                    <th>RFC</th>
                    <th>curp</th>
                    <th>NSS</th>
                    <th>Sucursal</th>
                    <th>Contacto de emergencia</th>
                    <th>Puesto</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado por</th>
                    <th>Actualizado por</th>
                    <th>Cancelado por</th>
                    <th>Eliminado por</th>
                    @endif
                    <th>Activo</th>
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $employee->name }} {{ $employee->first_lastname }} {{ $employee->seccond_lastname }}</td>
                    <td>{{ $employee->street }} #{{ $employee->exterior_number }} @if ($employee->interior_number != ""), #{{ $employee->interior_number }} @endif, {{ $employee->colony }}, {{ $employee->zip_code }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    <td>{{ $employee->birth_date }}</td>
                    <td>
                        @if ($employee->gender === "M")
                            Masculino
                        @elseif ($employee->gender === "F")
                            Femenino
                        @else
                            Otro
                        @endif
                    </td>
                    <td>{{ $employee->RFC }}</td>
                    <td>{{ $employee->curp }}</td>
                    <td>{{ $employee->NSS }}</td>
                    <td>{{ $employee->branch->name }}</td>
                    <td>{{ $employee->emergency_contact }}</td>
                    <td>{{ $employee->position->name }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        @if ($employee->active == "S")
                            Si
                        @else
                            No
                        @endif
                    </td>
                    <td>{{ $employee->created_at->diffForHumans() }}</td>
                    <td>{{ $employee->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $employee->created_at->diffForHumans() }}</td>
                    <td>{{ $employee->created_at->format('d/m/Y h:i:s') }}</td>

                    <td>
                        <a class="btn btn-lg btn-outline-info" href="{{ route('employees.show', $employee->id) }}">
                            <i class="fas fa-fw fa-eye"></i>
                        </a>
                        <a class="btn btn-lg btn-outline-warning" href="{{ route('employees.edit', $employee->id) }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>

                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-lg btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">
                                <i class="fas fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn btn-group-lg">
                            <a href="{{ route('employees.pdf', $employee->id) }}" class="btn btn-lg btn-outline-danger">
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('employees.docx', $employee->id) }}" class="btn btn-lg btn-outline-primary">
                                <i class="fas fa-fw fa-file-word"></i>
                            </a>
                            <a href="{{ route('employees.xlsx', $employee->id) }}" class="btn btn-lg btn-outline-success">
                                <i class="fas fa-fw fa-file-excel"></i>
                            </a>
                            <a href="{{ route('employees.email', $employee->id) }}" class="btn btn-lg btn-outline-info">
                                <i class="fas fa-fw fa-envelope"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
