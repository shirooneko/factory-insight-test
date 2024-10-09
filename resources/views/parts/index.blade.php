<!-- resources/views/parts/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Parts</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Master Data</h2>
        <a href="{{ route('parts.create') }}" class="btn btn-primary">+ Add New Part</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Model</th>
                <th>Part Name</th>
                <th>Part Number</th>
                <th>Part Code</th>
                <th>Quantity Cart</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parts as $part)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $part->model->model_name }}</td>
                    <td>{{ $part->part_name }}</td>
                    <td>{{ $part->part_number }}</td>
                    <td>{{ $part->part_code }}</td>
                    <td>{{ $part->capacity_in_cart }}</td>
                    <td>
                        <span class="badge {{ $part->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $part->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('parts.edit', $part->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('parts.destroy', $part->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
