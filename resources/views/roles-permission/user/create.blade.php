@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Create User</h2>
        <a class="btn btn-primary" href="{{ route('users.index') }}">View Users</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Add User</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="sr-only">Name</label>
                                <input id="name" type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input id="email" type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" type="password" name="password" placeholder="Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="role" class="sr-only">Role</label>
                                <select id="role" name="role[]" class="form-control" multiple>
                                    <option value="" disabled>Select Role(s)</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
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
