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
        <a href="{{ route('branches.pdf') }}" class="btn btn-lg btn-outline-danger">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>

        <a href="{{ route('branches.docx') }}" class="btn btn-lg btn-outline-primary">
            <i class="fas fa-fw fa-file-word"></i>
        </a>

        <a href="{{ route('branches.xlsx') }}" class="btn btn-lg btn-outline-success">
            <i class="fas fa-fw fa-file-excel"></i>
        </a>

        <a href="{{ route('branches.create') }}" class="btn btn-lg btn-outline-warning">
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
                    <th>Direccion</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                     <th>No.</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                    <th>Reportes</th>
                </tr>
            </tfoot>
            <tbody>

            @foreach ($branches as $branch)
                <tr>

                <td>{{ $index++ }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->street }} {{ $branch->exterior_number }} {{ $branch->interior_number }} {{ $branch->colony }} {{ $branch->zip_code }}</td>
                    <td>{{ $branch->phone }}</td>
                    <td>
                        <div class="btn btn-lg">
                            <a href="{{ route('branches.show', encrypt($branch->id)) }}" class="btn btn-outline-info">
                                <i class="fas fa-fw fa-eye"></i>
                            </a>

                            <a href="{{ route('branches.edit', encrypt($branch->id)) }}" class="btn btn-outline-warning">
                                <i class="fas fa-fw fa-edit"></i>
                            </a>
                            <form action="{{ route('branches.destroy', encrypt($branch->id)) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="btn btn-lg">
                            <a href="{{ route('branches.pdf', encrypt($branch->id)) }}" class="btn btn-outline-danger">
                                <i class="fas fa-fw fa-file-pdf"></i>
                            </a>

                            <a href="{{ route('branches.docx', encrypt($branch->id)) }}" class="btn btn-outline-primary">
                                <i class="fas fa-fw fa-file-word"></i>
                            </a>

                            <a href="{{ route('branches.xlsx', encrypt($branch->id)) }}" class="btn btn-outline-success">
                                <i class="fas fa-fw fa-file-excel"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @endforeach
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
