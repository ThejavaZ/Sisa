@extends('layout.main')

@section('top-title', 'Departamentos')

@section('title', 'Departamentos')

@section('breadcrumb')
    <li class="breadcrumb-item breadcrumb">
        <a href="">Inicio</a>
    </li>
    <li class="breadcrumb breadcrumb-item active">
        Departamentos
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
        Departamentos
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nombre</th>
                    <th>Gerente</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                    <th>Salary</th>
                    <th>Salary</th>
                    <th>Acciones</th>
                    <th>Reportes</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                    <th>Salary</th>
                    <th>Salary</th>
                    <th>Salary</th>
                    <th>Salary</th>

                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
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
            </tbody>
        </table>
    </div>
</div>

@endsection
