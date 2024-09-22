@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Pharmacy List</h2>
        <a class="btn btn-primary" href="{{ route('pharmacies.create') }}">Add Pharmacy</a>
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
                    <div class="title"><strong>Pharmacies</strong></div>
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pharmacies as $pharmacy)
                                    <tr>
                                        <td>{{ $pharmacy->id }}</td>
                                        <td>{{ $pharmacy->name }}</td>
                                        <td>{{ $pharmacy->type }}</td>
                                        <td>{{ $pharmacy->created_at }}</td>
                                        <td>
                                            <a href="{{ route('pharmacies.edit', $pharmacy->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('pharmacies.destroy', $pharmacy->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this pharmacy?');">Delete</button>
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
