@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Create Category</h2>
        <a class="btn btn-primary" href="{{route('roles.index')}}">View role</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Add role</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{route('roles.store')}}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="sr-only">Name</label>
                                <input id="name" type="text" name="name" placeholder=" Name" class="form-control" value="{{ old('name') }}">
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
