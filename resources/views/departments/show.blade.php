@extends('layout.app')

@section('content')
    <h1>Department Details</h1>
    <p><strong>Name:</strong> {{ $department->name }}</p>
    <p><strong>Cost Center:</strong> {{ $department->cost_center }}</p>
@endsection
