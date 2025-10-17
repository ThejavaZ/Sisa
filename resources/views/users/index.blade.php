@extends('layout.main')

@section('top-title','Usuarios')

@section('title','Usuarios')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active">
        Usuarios
    </li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-lg btn-outline-danger" href="{{ route('users.pdf') }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-lg btn-outline-primary" href="{{ route('users.docx') }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-lg btn-outline-success" href="{{ route('users.xlsx') }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a class="btn btn-lg btn-outline-info" href="{{ route('users.email') }}">
        <i class="fas fa-fw fa-envelope"></i>
    </a>

    @if (Auth::user()->role <= 4)
    <a class="btn btn-lg btn-outline-warning" href="{{ route('users.create') }}">
        <i class="fas fa-fw fa-plus"></i>
    </a>
    @endif
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user me-1"></i>
        Usuarios
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    @if (Auth::user()->role <= 1)
                    <th>ID</th>
                    @endif
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cambiar contraseña</th>
                    <th>Rol</th>
                    <th>Idioma</th>
                    <th>Activo</th>
                    @if (Auth::user()->role <= 1)
                    <th>Estado</th>

                    <th>Creado Por</th>
                    <th>Fecha de creacion</th>
                    <th>Creado hace</th>
                    
                    <th>Actualizado Por</th>
                    <th>Fecha de actualización</th>
                    <th>Actualizado hace</th>
                    
                    <th>Cancelado Por</th>
                    <th>Fecha de cancelacion</th>
                    <th>Cancelado hace</th>
                    
                    <th>Eliminado Por</th>
                    <th>Fecha de eliminacion</th>
                    <th>Eliminado hace</th>
                    @endif
                    @if (Auth::user()->role <= 4)
                    <th>Acciones</th>
                    @endif
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    @if (Auth::user()->role <= 1)
                    <th>ID</th>
                    @endif
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cambiar contraseña</th>
                    <th>Rol</th>
                    <th>Idioma</th>
                    <th>Activo</th>
                    @if (Auth::user()->role <= 1)
                    <th>Estado</th>

                    <th>Creado Por</th>
                    <th>Fecha de creacion</th>
                    <th>Creado hace</th>
                    
                    <th>Actualizado Por</th>
                    <th>Fecha de actualización</th>
                    <th>Actualizado hace</th>
                    
                    <th>Cancelado Por</th>
                    <th>Fecha de cancelacion</th>
                    <th>Cancelado hace</th>
                    
                    <th>Eliminado Por</th>
                    <th>Fecha de eliminacion</th>
                    <th>Eliminado hace</th>
                    @endif
                    @if (Auth::user()->role <= 4)
                    <th>Acciones</th>
                    @endif
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $index++ }}</td>
                    @if (Auth::user()->role <= 1)
                    <td>{{ $user->id }}</th>
                    @endif
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->id != 1)
                        <form action="{{ route('users.password', $user->id) }}"  method="POST" class="d-inline">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-lg btn-outline-dark">
                                <i class="fas fa-fw fa-lock"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                    <td>

                        @switch($user->role)
                            @case(0)
                                <span class="badge bg-black">root</span>
                                @break

                            @case(1)
                                <span class="badge bg-primary">Administrador</span>
                                @break

                            @case(2)
                                <span class="badge bg-success">Gerente</span>
                                @break

                            @case(3)
                                <span class="badge bg-info">Operador</span>
                                @break

                            @case(4)
                                <span class="badge bg-warning">Contador</span>
                                @break

                            @case(5)
                                <span class="badge bg-light">Cliente</span>
                                @break

                            @case(6)
                                <span class="badge bg-dark">Proveedor</span>
                                @break

                            @default
                                <span class="badge bg-dark">Desconocido</span>
                        @endswitch

                    </td>
                    <td>
                        @switch($user->language)
                            @case(1)
                                <span class="badge bg-danger">Español</span>
                                @break

                            @case(2)
                                <span class="badge bg-primary">Inglés</span>
                                @break

                            @default
                                <span class="badge bg-dark">Desconocido</span>
                        @endswitch
                    </td>
                    @if (Auth::user()->role <= 1)

                    @endif
                    <td>
                        @switch($user->active)
                            @case("S")
                            <span class="badge bg-success">Activo</span>
                                @break

                            @case("N")
                            <span class="badge bg-danger">Inactivo</span>
                                @break
                            @default
                            <span class="badge bg-black">Desconocido</span>
                        @endswitch
                    </td>
                    @if (Auth::user()->role <= 1)
                    <td>
                        @switch($user->status)
                            @case(1)
                            <span class="badge bg-success">Activo</span>
                                @break

                            @case(0)
                            <span class="badge bg-danger">Inactivo</span>
                                @break
                            @default
                            <span class="badge bg-black">Desconocido</span>
                        @endswitch
                    </td>
                    <td>{{ $user->created_user?->name ?? 'No info' }} {{  $user->created_user?->email ?? null}}</td>
                    <td>{{ $user->created_at->diffForHumans() ?? "No info" }}</td>
                    <td>{{ $user->created_at->format('d/m/Y h:i:s') ?? "No info" }}</td>
                    <td>{{ $user->updated_user?->name ?? 'No info' }} {{ $user->updated_user?->email ?? null }}</td>
                    <td>{{ $user->updated_at->diffForHumans() ?? "No info" }}</td>
                    <td>{{ $user->updated_at->format('d/m/Y h:i:s') ?? "No info" }}</td>
                    <td>{{ $user->cancel_user?->name ?? 'No info' }} {{ $user->cancel_user?->email ?? null }}</td>
                    <td>{{ $user->cancel_at?->diffForHumans() ?? "No info" }}</td>
                    <td>{{ $user->cancel_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                    <td>{{ $user->deleted_user?->name ?? 'No info' }} {{ $user->deleted_user?->email ?? null }}</td>
                    <td>{{ $user->deleted_at?->diffForHumans() ?? "No info" }}</td>
                    <td>{{ $user->deleted_at?->format('d/m/Y h:i:s') ?? "No info" }}</td>
                    @endif
                    @if (Auth::user()->role <= 4)
                    <td>
                        @if ($user->id != 1)
                            <a href="{{ route('users.show', encrypt($user->id)) }}" class="btn btn-lg btn-outline-info">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', encrypt($user->id)) }}" class="btn btn-lg btn-outline-warning">
                                <i class="fas fa-fw fa-edit"></i>
                            </a>

                            <form action="{{ route('users.cancel', encrypt($user->id)) }}"  method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-lg btn-outline-danger">
                                    <i class="fas fa-fw fa-x"></i>
                                </button>
                            </form>

                            <form action="{{ route('users.destroy', encrypt($user->id)) }}"  method="POST" class="d-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-lg btn-outline-danger">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                    @endif
                    <td>
                        @if ($user->id != 1)
                            <div class="btn-group-lg">
                                <a href="{{ route('users.pdf', $user->id) }}" class="btn btn-outline-danger">
                                    <i class="fas fa-fw fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('users.docx', $user->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-fw fa-file-word"></i>
                                </a>
                                <a href="{{ route('users.xlsx', $user->id) }}" class="btn btn-outline-success">
                                    <i class="fas fa-fw fa-file-excel"></i>
                                </a>
                                <a href="{{ route('users.email', $user->id) }}" class="btn btn-outline-info">
                                    <i class="fas fa-fw fa-envelope"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
