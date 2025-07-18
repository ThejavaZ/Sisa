@extends('layout.main')

@section('top-title', 'Puestos')

@section('title', 'Puestos')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Puestos</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <a class="btn btn-lg btn-outline-danger" href="{{ route('positions.pdf') }}" target="_blank">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>

        <a class="btn btn-lg btn-outline-primary" href="{{ route('positions.docx') }}" target="_blank">
            <i class="fas fa-fw fa-file-word"></i>
        </a>

        <a class="btn btn-lg btn-outline-success" href="{{ route('positions.xlsx') }}" target="_blank">
            <i class="fas fa-fw fa-file-excel"></i>
        </a>

        <a class="btn btn-lg btn-outline-info" href="{{ route('positions.email') }}">
            <i class="fas fa-fw fa-envelope"></i>
        </a>

        <a class="btn btn-lg btn-outline-warning" href="{{ route('positions.create') }}">
            <i class="fas fa-fw fa-plus"></i>
        </a>
    </div>

    <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-sitemap me-1"></i>
        Puestos
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Departamento</th>
                    <th>Descripcion</th>
                    <th>Salario</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado por</th>
                    <th>Actualizado por</th>
                    <th>Cancelado por</th>
                    <th>Eliminado por</th>
                    @endif
                    <th>Activo</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    @endif
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Departamento</th>
                    <th>Descripcion</th>
                    <th>Salario</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado por</th>
                    <th>Actualizado por</th>
                    <th>Cancelado por</th>
                    <th>Eliminado por</th>
                    @endif
                    <th>Activo</th>
                    @if (Auth::user()->role == 1)
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    <th>Creado hace</th>
                    <th>Creado</th>
                    <th>Actualizado hace</th>
                    <th>Actualizado</th>
                    @endif
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($positions as $position)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $position->name }}</td>
                    <td>
                        @if ($position->level == 1)
                            Administrativo
                        @elseif ($position->level == 2)
                            Operativo
                        @elseif ($position->level == 3)
                            Supervicion/Cordinacion
                        @elseif ($position->level == 4)
                            Direccion/Gerencia
                        @else
                            desconocido
                        @endif
                    </td>
                    <td>{{ $position->department->name }}</td>
                    <td>{{ $position->description }}</td>
                    <td>${{ $position->salary }}</td>
                    @if (Auth::user()->role == 1)
                    <th>Creado por</th>
                    <th>Actualizado por</th>
                    <th>Cancelado por</th>
                    <th>Eliminado por</th>
                    @endif
                    <td>
                        @if ($position->active == "S")
                            Si
                        @else
                            No
                        @endif
                    </td>
                    @if (Auth::user()->role == 1)
                    <td>{{ $position->created_at->diffForHumans() }}</td>
                    <td>{{ $position->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $position->created_at->diffForHumans() }}</td>
                    <td>{{ $position->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $position->created_at->diffForHumans() }}</td>
                    <td>{{ $position->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $position->created_at->diffForHumans() }}</td>
                    <td>{{ $position->created_at->format('d/m/Y h:i:s') }}</td>
                    @endif
                    <td>
                        <a class="btn btn-lg btn-outline-info" href="{{ route('positions.show', $position->id) }}">
                            <i class="fas fa-fw fa-eye"></i>
                        </a>
                        <a class="btn btn-lg btn-outline-warning" href="{{ route('positions.edit', $position->id) }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>
                        <a class="btn btn-lg btn-outline-danger" href="{{ route('positions.edit', $position->id) }}">
                            <i class="fas fa-fw fa-x"></i>
                        </a>
                        @if (Auth::user()->role == 1)
                            <form action="{{ route('positions.destroy', $position->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-lg btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <a href="" class="btn btn-lg btn-outline-danger">
                            <i class="fas fa-fw fa-file-pdf"></i>
                        </a>
                        <a href="" class="btn btn-lg btn-outline-primary">
                            <i class="fas fa-fw fa-file-word"></i>
                        </a>
                        <a href="" class="btn btn-lg btn-outline-success">
                            <i class="fas fa-fw fa-file-excel"></i>
                        </a>
                        <a href="" class="btn btn-lg btn-outline-info">
                            <i class="fas fa-fw fa-envelope"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
