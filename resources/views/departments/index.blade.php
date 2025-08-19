@extends('layout.main')

@section('content')
    <h1>Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary">Create Department</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Cost Center</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->cost_center }}</td>
                    <td>
                        <a href="{{ route('departments.show', Crypt::encrypt($department->id)) }}" class="btn btn-info">View</a>
                        <a href="{{ route('departments.edit', Crypt::encrypt($department->id)) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
