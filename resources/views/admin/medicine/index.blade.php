@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Medicine List</h2>
        <a class="btn btn-primary" href="{{ route('medicines.create') }}">Add Medicine</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="block margin-bottom-sm">
                    <div class="title"><strong>Medicines</strong></div>
                    <div class="table-responsive">
                        <table class="table" id="myTable"> 
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Generic Name</th>
                                    <th>Company</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($medicines as $medicine)
                                    <tr>
                                        <td>{{ $medicine->id }}</td>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->generic->name ?? 'N/A' }}</td>
                                        <td>{{ $medicine->company->name ?? 'N/A' }}</td>
                                        <td>{{ $medicine->description }}</td>
                                        <td>{{ $medicine->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this medicine?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
