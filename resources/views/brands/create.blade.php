@extends('layout.app')

@section('content')
    <h1>Create Brand</h1>
    <form action="{{ route('brands.store') }}" method="POST">
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
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
