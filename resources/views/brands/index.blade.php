@extends('layout.main')

@section('content')
    <h1>Brands</h1>
    <a href="{{ route('brands.create') }}" class="btn btn-primary">Create Brand</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Website</th>
                <th>Support Email</th>
                <th>Active Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->website }}</td>
                    <td>{{ $brand->support_email }}</td>
                    <td>{{ $brand->is_active_supplier ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('brands.show', Crypt::encrypt($brand->id)) }}" class="btn btn-info">View</a>
                        <a href="{{ route('brands.edit', Crypt::encrypt($brand->id)) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
