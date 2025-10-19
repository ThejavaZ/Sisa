@extends('layout.main')

@section('top-title', 'departamentos')

@section('title', 'departamentos')

@section('breadcrumb')

<li class="breadcrumb breadcrumb-item"><a href="{{ route('home') }}">Incio</a></li>
<li class="breadcrumb breadcrumb-item active">Departamentos</li>

@endsection

@section('content')

    <div>
        <a class="btn btn-lg btn-outline-danger" href="">
            <i class="fas fa-file-pdf"></i>
        </a>

        <a class="btns btn-outline-danger" href="">
            <i class="fas fa-fw fa-file-pdf"></i>
        </a>
        
        <a class="btns btn-outline-danger" href="">
            <i class="fas fa-file-pdf"></i>
        </a>

        <a class="btns btn-outline-danger" href="">
            <i class="fas fa-file-pdf"></i>
        </a>

    </div>
    
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
