@extends('layout.main')

@section('top-title', 'Sucursales')

@section('title', 'Sucursales')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Inicio</a>
    </li>
    <li class="breadcrumb-item active">
        Sucursales
    </li>
@endsection

@section('content')
<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a href="" class="btn btn-lg btn-outline-danger">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>

    <a href="" class="btn btn-lg btn-outline-primary">
        <i class="fas fa-fw fa-file-word"></i>
    </a>

    <a href="" class="btn btn-lg btn-outline-success">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>

    <a href="" class="btn btn-lg btn-outline-warning">
        <i class="fas fa-fw fa-plus"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DataTable Example
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Manager</th>
                    <th>Dirreccion</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                    <th>Reportes</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Manager</th>
                    <th>Dirreccion</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                    <th>Reportes</th>

                </tr>
            </tfoot>
            <tbody>
                @foreach ($branches as $branch)
                <tr>
                    <th>{{ $index++ }}</th>
                    <th>{{ $branch->name }}</th>
                    <th>{{ $branch->employee->name ?? "Sin dato"}}</th>
                    <th>{{ $branch->street }}, {{ $branch->colony }}</th>
                    <th>Celular</th>
                    <td>
                        <div class="btn btn-lg">
                            <a href="" class="btn btn-outline-info">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>

                            <a href="" class="btn btn-outline-warning">
                                <i class="fas fa-fw fa-edit"></i>
                            </a>

                            <a href="" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-x"></i>
                            </a>

                            <a href="" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-trash"></i>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="btn btn-lg">
                            <a href="" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>

                            <a href="" class="btn btn-outline-primary">
                                <i class="fas fa-fw fa-file-word"></i>
                            </a>

                            <a href="" class="btn btn-outline-success">
                                <i class="fas fa-fw fa-file-excel"></i>
                            </a>

                            <a href="" class="btn btn-outline-info">
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
