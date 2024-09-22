@extends('admin.index')

@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Edit Product</h2>
        <a class="btn btn-primary" href="{{ route('companies.index') }}">View Company List</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Edit Permission</strong></div>
                    <div class="block-body">
                    <form method="POST" action="{{ route('companies.update', $companies->id) }}" >
    @csrf
    @method('PUT')
                            
                            <!-- Title -->
                            <div class="form-group">
                                <label for="name" class="sr-only">Name</label>
                                <input id="name" type="text" name="name" placeholder=" Name" class="form-control" value="{{ old('name', $companies->name) }}">
                            </div>

                            <!-- Description -->
                            

                          

                            <!-- Quantity -->
                           

                            <!-- Product Image -->
                          
                            <!-- Current Image Display -->
                            

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
