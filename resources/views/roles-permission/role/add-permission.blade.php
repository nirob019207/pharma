@extends('admin.index')

@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Edit Role</h2>
        <a class="btn btn-primary" href="{{ route('roles.index') }}">View Role List</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Edit Role</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{ route('roles.updatePermissions', ['roleId' => $role->id]) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Checkbox for permission -->
                            <div class="form-group row">
                                <div class="col-sm-9 d-flex align-items-center">
                                    @foreach($permissions as $permission)
                                    <div class="form-check d-flex align-items-center ml-4">
                                        <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permission[]" value="{{ $permission->name }}" {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label ml-2" for="permission-{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
