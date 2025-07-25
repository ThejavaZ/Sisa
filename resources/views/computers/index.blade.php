@extends('layout.main')

@section('top-title',Auth::user()?->languaje == 1 ? 'Computadoras' : 'Computers')

@section('title', Auth::user()?->languaje == 1 ? 'Computadoras' : 'Computers')

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
    @if (Auth::user()->languaje == 1)
        Computadoras
    @else
        Computers
    @endif
</li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-lg btn-outline-danger" href="{{ route('computers.pdf') }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-lg btn-outline-primary" href="{{ route('computers.docx') }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-lg btn-outline-success" href="{{ route('computers.xlsx') }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a href="{{ route('computers.email') }}" class="btn btn-lg btn-outline-info">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-lg btn-outline-warning" href="{{ route('computers.create') }}">
        <i class="fas fa-fw fa-plus"></i>
    </a>
</div>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-computer me-1"></i>
        @if (Auth::user()->languaje == 1)
            Computadoras
        @else
            Computers
        @endif
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                     <th>No.</th>
                    <th>Nombre</th>
                    <th>Numero de serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Descripción</th>
                    <th>Especificaciones</th>
                    <th>Sistema operativo</th>
                    <th>Fecha de Compra</th>
                    <th>Garantia hasta</th>
                    <th>Sucursal</th>
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
                    <th>Cancelado hace</th>
                    <th>Cancelado</th>
                    <th>Eliminado hace</th>
                    <th>Eliminado</th>
                    @endif
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Numero de serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Descripción</th>
                    <th>Especificaciones</th>
                    <th>Sistema operativo</th>
                    <th>Fecha de Compra</th>
                    <th>Garantia hasta</th>
                    <th>Sucursal</th>
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
                    <th>Cancelado hace</th>
                    <th>Cancelado</th>
                    <th>Eliminado hace</th>
                    <th>Eliminado</th>
                    @endif
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($computers as $computer)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $computer->name }}</td>
                    <td>{{ $computer->serial_number }}</td>
                    <td>{{ $computer->brand->name }}</td>
                    <td>{{ $computer->model }}</td>
                    <td>{{ $computer->description }}</td>
                    <td>{{ $computer->specify }}</td>
                    <td>{{ $computer->os }}</td>
                    <td>{{ $computer->purchase_date }}</td>
                    <td>{{ $computer->warranty_until }}</td>
                    <td>{{ $computer->branch->name }}</td>
                    @if (Auth::user()->role == 1)
                    <td>{{ $computer->created_user->name?? "No info" }}({{ $computer->created_user->email?? "No info" }})</td>
                    <td>{{ $computer->updated_user->name?? "No info" }}({{ $computer->updated_user->email?? "No info" }})</td>
                    <td>{{ $computer->cancel_user->name?? "No info" }}({{ $computer->cancel_user->email?? "No info" }})</td>
                    <td>{{ $computer->deleted_user->name?? "No info" }}({{ $computer->deleted_user->email?? "No info" }})</td>
                    @endif
                    <td>
                        @if ($computer->active == "S")
                            <span class="badge bg-success">
                                Si
                            </span>
                        @else
                            <span class="badge bg-danger">
                                No
                            </span>
                        @endif
                    </td>
                    @if (Auth::user()->role == 1)
                        <td>{{ $computer->created_at?->diffForHumans() ?? "No info" }}</td>
                        <td>{{ $computer->created_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                        <td>{{ $computer->updated_at?->diffForHumans() ?? "No info" }}</td>
                        <td>{{ $computer->updated_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                        <td>{{ $computer->cancel_at?->diffForHumans() ?? "No info" }}</td>
                        <td>{{ $computer->cancel_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                        <td>{{ $computer->deleted_at?->diffForHumans() ?? "No info"}}</td>
                        <td>{{ $computer->deleted_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                    @endif

                    <td>
                        <a class="btn btn-lg btn-outline-info" href="{{ route('computers.show', encrypt($computer->id)) }}">
                            <i class="fas fa-fw fa-eye"></i>
                        </a>
                        <a class="btn btn-lg btn-outline-warning" href="{{ route('computers.edit', encrypt($computer->id)) }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>

                        <form action="{{ route('computers.cancel', encrypt($computer->id)) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-lg btn-outline-danger" onclick="return confirm('¿Estás seguro de cancelar esta computadora?')">
                                <i class="fas fa-fw fa-x"></i>
                            </button>
                        </form>
                        @if (Auth::user()->role == 1)
                        <form action="{{ route('computers.destroy', encrypt($computer->id)) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-lg btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">
                                <i class="fas fa-fw fa-trash"></i>
                            </button>
                        </form>
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('computers.pdf', encrypt($computer->id)) }}" class="btn btn-lg btn-outline-danger" target="_blank">
                            <i class="fas fa-fw fa-file-pdf"></i>
                        </a>
                        <a href="{{ route('computers.docx', encrypt($computer->id)) }}" class="btn btn-lg btn-outline-primary">
                            <i class="fas fa-fw fa-file-word"></i>
                        </a>
                        <a href="{{ route('computers.xlsx', encrypt($computer->id)) }}" class="btn btn-lg btn-outline-success">
                            <i class="fas fa-fw fa-file-excel"></i>
                        </a>
                        <a href="">

                        </a>
                        <a href="{{ route('computers.email', encrypt($computer->id)) }}" class="btn btn-lg btn-outline-info">
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
