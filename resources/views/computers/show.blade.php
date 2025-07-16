@extends('layout.main')

@section('top-title', $computer->name)

@section('title',$computer->name)

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('home') }}">
    Inicio
    </a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('computers') }}">
    Computadoras
    </a>
</li>
<li class="breadcrumb-item active">{{ $computer->name }}</li>
@endsection

@section('content')

<div class="d-flex justify-content-between mb-4">
    <a class="btn btn-lg btn-outline-danger" href="{{ route('computers.pdf', $computer->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-lg btn-outline-primary" href="{{ route('computers.docx', $computer->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-lg btn-outline-success" href="{{ route('computers.xlsx', $computer->id) }}" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a class="btn btn-lg btn btn-outline-info" href="{{ route('computers.email', $computer->id) }}">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-lg btn-outline-warning" href="{{ route('computers.edit', $computer->id) }}">
        <i class="fas fa-fw fa-edit"></i>
    </a>
</div>

<div class="card mb-4 shadow">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="fas fa-computer me-2"></i>
        <span>{{ $computer->name }}</span>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-6"><strong>ID:</strong> {{ $computer->id }}</div>
            <div class="col-md-6"><strong>Nombre:</strong> {{ $computer->name }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Numero de serie:</strong> {{ $computer->serial_number }}</div>
            <div class="col-md-6"><strong>Marca:</strong> {{ $computer->brand_id }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Numero de serie:</strong> {{ $computer->serial_number }}</div>
            <div class="col-md-6"><strong>Marca:</strong> {{ $computer->brand_id }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Modelo:</strong> {{ $computer->model }}</div>
            <div class="col-md-6"><strong>Sistema Operativo:</strong> {{ $computer->OS }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Fecha de compra:</strong> {{ $computer->purchase_date }}</div>
            <div class="col-md-6"><strong>Fecha de garantia:</strong> {{ $computer->warranty_until }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Sucursal:</strong> {{ $computer->branch_id }}</div>
            <div class="col-md-6"><strong>Activo:</strong> {{ $computer->active === 'S' ? 'Sí' : 'No' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Creado:</strong> {{ $computer->created_at->format('d/m/Y H:i') }}</div>
            <div class="col-md-6"><strong>Actualizado:</strong> {{ $computer->updated_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="mt-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-sticky-note me-2"></i>Especificaciones
                </div>
                <div class="card-body">
                    {{ $computer->specify ?? 'Sin especificaciones.' }}
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-sticky-note me-2"></i>Descripcion
                </div>
                <div class="card-body">
                    {{ $computer->description ?? 'Sin descripcion.' }}
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('computers') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
</div>

@endsection
