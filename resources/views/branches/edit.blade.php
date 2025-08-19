@extends('layout.main')

@section('content')
    <h1>Edit Branch</h1>
    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
        </div>
        <div class="form-group">
            <label for="street">Street</label>
            <input type="text" name="street" class="form-control" value="{{ $branch->street }}" required>
        </div>
        <div class="form-group">
            <label for="interior_number">Interior Number</label>
            <input type="text" name="interior_number" class="form-control" value="{{ $branch->interior_number }}">
        </div>
        <div class="form-group">
            <label for="exterior_number">Exterior Number</label>
            <input type="text" name="exterior_number" class="form-control" value="{{ $branch->exterior_number }}" required>
        </div>
        <div class="form-group">
            <label for="colony">Colony</label>
            <input type="text" name="colony" class="form-control" value="{{ $branch->colony }}" required>
        </div>
        <div class="form-group">
            <label for="zip_code">Zip Code</label>
            <input type="text" name="zip_code" class="form-control" value="{{ $branch->zip_code }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $branch->phone }}" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="is_main" class="form-check-input" {{ $branch->is_main ? 'checked' : '' }}>
            <label class="form-check-label" for="is_main">Is Main</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
