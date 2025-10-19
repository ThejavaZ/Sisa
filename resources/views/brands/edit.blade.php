@extends('layout.main')

@section('content')
    <h1>Edit Brand</h1>
    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input type="text" name="website" class="form-control" value="{{ $brand->website }}" required>
        </div>
        <div class="form-group">
            <label for="support_email">Support Email</label>
            <input type="email" name="support_email" class="form-control" value="{{ $brand->support_email }}" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_active_supplier" class="form-check-input" {{ $brand->is_active_supplier ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active_supplier">Active Supplier</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
