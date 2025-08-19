@extends('layout.app')

@section('content')
    <h1>Brand Details</h1>
    <p><strong>Name:</strong> {{ $brand->name }}</p>
    <p><strong>Website:</strong> {{ $brand->website }}</p>
    <p><strong>Support Email:</strong> {{ $brand->support_email }}</p>
    <p><strong>Active Supplier:</strong> {{ $brand->is_active_supplier ? 'Yes' : 'No' }}</p>
@endsection
