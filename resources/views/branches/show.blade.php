@extends('layout.main')

@section('top-title', $branch->name)

@section('title', $branch->name )

@section('content')

<div class="d-flex btn-group-lg justify-content-between mb-4">
    <a class="btn  btn-outline-danger" href="" target="_blank">
        <i class="fas fa-fw fa-file-pdf"></i>
    </a>
    <a class="btn btn-outline-primary" href="" target="_blank">
        <i class="fas fa-fw fa-file-word"></i>
    </a>
    <a class="btn btn-outline-success" href="" target="_blank">
        <i class="fas fa-fw fa-file-excel"></i>
    </a>
    <a href="" class="btn btn-outline-info">
        <i class="fas fa-fw fa-envelope"></i>
    </a>
    <a class="btn btn-outline-warning" href="">
        <i class="fas fa-fw fa-edit"></i>
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-shop me-2"></i> {{ $branch->name }}
    </div>
    <div class="card-body">
        <p><strong>Nombre:</strong> </p>
        <p><strong>Direccion:</strong> </p>
        <p><strong>Celular:</strong> </p>
        <p><strong>ID:</strong> </p>
        <p><strong>ID:</strong> </p>
        <p><strong>ID:</strong> </p>
        <p><strong>ID:</strong> </p>
    </div>
    <div class="card-footer text-end">
        <a href="" class="btn btn-lg btn-secondary">
            <i class="fas fa-fw fa-arrow-left"></i>
        </a>
    </div>
</div>

    <h1>Branch Details</h1>
    <p><strong>Name:</strong> {{ $branch->name }}</p>
    <p><strong>Street:</strong> {{ $branch->street }}</p>
    <p><strong>Interior Number:</strong> {{ $branch->interior_number }}</p>
    <p><strong>Exterior Number:</strong> {{ $branch->exterior_number }}</p>
    <p><strong>Colony:</strong> {{ $branch->colony }}</p>
    <p><strong>Zip Code:</strong> {{ $branch->zip_code }}</p>
    <p><strong>Phone:</strong> {{ $branch->phone }}</p>
    <p><strong>Is Main:</strong> {{ $branch->is_main ? 'Yes' : 'No' }}</p>
@endsection
