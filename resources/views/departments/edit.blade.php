@extends('layout.app')

@section('content')
    <h1>Edit Department</h1>
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $department->name }}" required>
        </div>
        <div class="form-group">
            <label for="cost_center">Cost Center</label>
            <input type="text" name="cost_center" class="form-control" value="{{ $department->cost_center }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
