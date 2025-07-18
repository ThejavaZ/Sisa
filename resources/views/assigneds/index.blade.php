@extends('layout.main')

@section('top-title','Asignadas')

@section('title','Asignadas')

@section('breadcrumb')

<li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
<li class="breadcrumb-item active">Asignadas</li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-lg btn-outline-danger" href="{{ route('assigneds.pdf') }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-lg btn-outline-primary" href="{{ route('assigneds.docx') }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-lg btn-outline-success" href="{{ route('assigneds.xlsx') }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a class="btn btn-lg btn-outline-info"  href="{{ route('assigneds.email') }}">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-lg btn-outline-warning" href="{{ route('assigneds.create') }}">
        <i class="fas fa-fw fa-plus"></i>
    </a>
</div>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-file me-1"></i>
        Asignadas
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
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
                @foreach ($assigned as $assigned)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $assigned->computer->name }}</td>
                    <td>{{ $assigned->employee->name }}</td>
                    <td>{{ $assigned->assigned_date }}</td>
                    <td>{{ $assigned->returned_date ?? "Sin fecha de regreso" }}</td>
                    <td>{{ $assigned->notes ?? "Sin notas"}}</td>
                    <td>{{ $assigned->user->name }} ({{ $assigned->user->email }})</td>
                    @if (Auth::user()->role == 1)
                    <th>{{ $user->created_user->name ?? "sin datos" }}</th>
                    <th>{{ $user->updated_user->name ?? "sin datos" }}</th>
                    <th>{{ $user->cancel_by->name ?? "sin datos" }}</th>
                    <th>{{ $user->deleted_user->name ?? "sin datos" }}</th>
                    @endif
                    <td>
                        @if ($assigned->active == "S")
                            <span class="badge bg-success">Activo</span>

                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $pdfPath = asset('storage/assigneds/' . $assigned->id . '.pdf');
                        @endphp
                        @if (file_exists(public_path('storage/assigneds/' . $assigned->id . '.pdf')))
                            <a class="btn btn-lg btn-outline-danger" href="{{ $pdfPath }}" target="_blank">
                                <i class="fas fa-fw fa-file"></i>
                            </a>
                        @else
                            <a href="{{ route('assigneds.card', $assigned->id) }}" class="btn btn-lg btn-outline-danger">
                                <i class="fas fa-fw fa-envelope"></i>
                            </a>
                        @endif
                    </td>
                    @if (Auth::user()->role == 1)
                    <td>{{ $assigned->created_at->diffForHumans() }}</td>
                    <td>{{ $assigned->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $assigned->created_at->diffForHumans() }}</td>
                    <td>{{ $assigned->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $assigned->created_at->diffForHumans() }}</td>
                    <td>{{ $assigned->created_at->format('d/m/Y h:i:s') }}</td>
                    <td>{{ $assigned->created_at->diffForHumans() }}</td>
                    <td>{{ $assigned->created_at->format('d/m/Y h:i:s') }}</td>
                    @endif

                    <td>
                        <a class="btn btn-lg btn-outline-info" href="{{ route('assigneds.show', $assigned->id) }}">
                            <i class="fas fa-fw fa-eye"></i>
                        </a>
                        <a class="btn btn-lg btn-outline-warning" href="{{ route('assigneds.edit', $assigned->id) }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>

                        <a class="btn btn-lg btn-outline-danger" href="">
                            <div class="fas fa-fw fa-x"></div>
                        </a>
                        @if (Auth::user()->role == 1)
                        <form action="{{ route('assigneds.destroy', $assigned->id) }}" method="POST">
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
