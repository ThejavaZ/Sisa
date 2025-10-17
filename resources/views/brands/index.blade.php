@extends('layout.main')

@section('top-title', Auth::user()->language == 1 ? 'Marcas' : 'Brands')

@section('title',  Auth::user()->language == 1 ? 'Marcas' : 'Brands')

@section('breadcrumb')

<li class="breadcrumb breadcrumb-item">
    <a href="{{ route('home') }}">Home</a>
</li>
<li class="breadcrumb breadcrumb-item active">Marcas</li>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-4 ">
        <a href="" class="btn btn-lg btn-outline-danger">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>
        <a href="" class="btn btn-lg btn-outline-primary">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>
        <a href="" class="btn btn-lg btn-outline-success">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>
        <a href="{{ route('brands.create') }}" class="btn btn-lg btn-outline-warning">
            <i class="fas fa-fw fa-plus"></i>
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file me-1"></i>
            Marcas
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No.</th>
                        @if (Auth::user()->role == 1)
                        <th>ID</th>
                        @endif
                        <th>Nombre</th>
                        <th>sitio web</th>
                        <th>correo de soporte</th>
                        <th>¿Es proveedor activo?</th>
                        <th>Activo</th>
                        @if (Auth::user()->role == 1)
                        <th>Fecha de creacion</th>
                        <th>Creado hace</th>
                        <th>Creado por</th>

                        <th>Fecha de Actualizacion</th>
                        <th>Actualizado hace</th>
                        <th>Actualizado por</th>

                        <th>Fecha de cancelacion</th>
                        <th>Cancelado hace</th>
                        <th>Cancelado por</th>

                        <th>Fecha de eliminado</th>
                        <th>Eliminado hace</th>
                        <th>Eliminado por</th>
                        @endif
                        <th>Acciones</th>
                        <th>Reportes</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Computadora</th>
                        <th>Empleado</th>
                        <th>Fecha</th>
                        <th>Fecha de regreso</th>
                        <th>Notas</th>
                        <th>Asignador</th>
                        @if (Auth::user()->role == 1)
                        <th>Creado por</th>
                        <th>Actualizado por</th>
                        <th>Cancelado por</th>
                        <th>Eliminado por</th>
                        @endif
                        <th>Activo</th>
                        <th>Carta</th>
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
                    @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>{{ $brand->computer->name }}</td>
                        <td>{{ $brand->employee->name }}</td>
                        <td>{{ $brand->brand_date }}</td>
                        <td>{{ $brand->returned_date ?? "Sin fecha de regreso" }}</td>
                        <td>{{ $brand->notes ?? "Sin notas"}}</td>
                        <td>{{ $brand->user->name }} ({{ $brand->user->email }})</td>
                        @if (Auth::user()->role == 1)
                        <th>{{ $user->created_user->name ?? "sin datos" }}</th>
                        <th>{{ $user->updated_user->name ?? "sin datos" }}</th>
                        <th>{{ $user->cancel_by->name ?? "sin datos" }}</th>
                        <th>{{ $user->deleted_user->name ?? "sin datos" }}</th>
                        @endif
                        <td>
                            @if ($brand->active == "S")
                                <span class="badge bg-success">Activo</span>

                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $pdfPath = asset('storage/brands/' . $brand->id . '.pdf');
                            @endphp
                            @if (file_exists(public_path('storage/brands/' . $brand->id . '.pdf')))
                                <a class="btn btn-lg btn-outline-danger" href="{{ $pdfPath }}" target="_blank">
                                    <i class="fas fa-fw fa-file"></i>
                                </a>
                            @else
                                <a href="{{ route('brands.card', $brand->id) }}" class="btn btn-lg btn-outline-danger">
                                    <i class="fas fa-fw fa-envelope"></i>
                                </a>
                            @endif
                        </td>
                        @if (Auth::user()->role == 1)
                        <td>{{ $brand->created_at->diffForHumans() }}</td>
                        <td>{{ $brand->created_at->format('d/m/Y h:i:s') }}</td>
                        <td>{{ $brand->created_at->diffForHumans() }}</td>
                        <td>{{ $brand->created_at->format('d/m/Y h:i:s') }}</td>
                        <td>{{ $brand->created_at->diffForHumans() }}</td>
                        <td>{{ $brand->created_at->format('d/m/Y h:i:s') }}</td>
                        <td>{{ $brand->created_at->diffForHumans() }}</td>
                        <td>{{ $brand->created_at->format('d/m/Y h:i:s') }}</td>
                        @endif

                        <td>
                            <a class="btn btn-lg btn-outline-info" href="{{ route('brands.show', $brand->id) }}">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>
                            <a class="btn btn-lg btn-outline-warning" href="{{ route('brands.edit', $brand->id) }}">
                                <i class="fas fa-fw fa-edit"></i>
                            </a>

                            <a class="btn btn-lg btn-outline-danger" href="">
                                <div class="fas fa-fw fa-x"></div>
                            </a>
                            @if (Auth::user()->role == 1)
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-lg btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar esta asignacion?')">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </form>
                            @endif

                        </td>
                        <td>
                            <div class="btn-lg">
                                <a href="" class="btn btn-lg brn btn-outline-danger">
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
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
