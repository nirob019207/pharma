@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Edit Pharmacy</h2>
        <a class="btn btn-primary" href="{{ route('pharmacies.index') }}">View Pharmacies</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Edit Pharmacy</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{ route('pharmacies.update', $pharmacy->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="sr-only">Name</label>
                                <input id="name" type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name', $pharmacy->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="type" class="sr-only">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="main" {{ $pharmacy->type == 'main' ? 'selected' : '' }}>Main</option>
                                    <option value="branch" {{ $pharmacy->type == 'branch' ? 'selected' : '' }}>Branch</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_id" class="sr-only">User</label>
                                <select id="user_id" name="user_id" class="form-control">
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $pharmacy->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
