@extends('layout.main')

@section('top-title', 'Crear marca')

@section('title', 'Crear marca')

@section('breadcrumb')
<li class="breadcrumb breadcrumb-item">
    <a href="{{ route('home') }}">
        Home
    </a>
</li>
<li class="breadcrumb breadcrumb-item">
    <a href="{{ route('brands') }}">
        Marcas
    </a>
</li>

@endsection

@section('content')
    <form action="{{ route('brands.store') }}" method="POST" class="form form-control p-10">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input type="text" name="website" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="support_email">Support Email</label>
            <input type="email" name="support_email" class="form-control" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_active_supplier" class="form-check-input">
            <label class="form-check-label" for="is_active_supplier">Active Supplier</label>
        </div>
        <div class="d-flex justify-content-around">
            <button type="submit" class="btn btn-lg btn-primary">
                <i class="fas fa-fw fa-save"></i>
            </button>
            <a href="{{ route('brands') }}" class="btn btn-lg btn-secondary">
                <i class="fas fa-fw fa-arrow-left"></i>
            </a>
        </div>

    </form>
@endsection
