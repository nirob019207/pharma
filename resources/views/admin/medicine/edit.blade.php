@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Edit Medicine</h2>
        <a class="btn btn-primary" href="{{ route('medicines.index') }}">View Medicines</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Edit Medicine</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{ route('medicines.update', $medicine->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name" class="sr-only">Name</label>
                                <input id="name" type="text" name="name" placeholder="Name" class="form-control" value="{{ old('name', $medicine->name) }}">
                            </div>
                            <select id="generic_id" name="generic_id" class="form-control">
    @foreach($generics as $generic)
        <option value="{{ $generic->id }}" {{ old('generic_id', $medicine->generic_id ?? '') == $generic->id ? 'selected' : '' }}>
            {{ $generic->name }}
        </option>
    @endforeach
</select>

<select id="company_id" name="company_id" class="form-control">
    @foreach($companies as $company)
        <option value="{{ $company->id }}" {{ old('company_id', $medicine->company_id ?? '') == $company->id ? 'selected' : '' }}>
            {{ $company->name }}
        </option>
    @endforeach
</select>

                            <div class="form-group">
                                <label for="description" class="sr-only">Description</label>
                                <textarea id="description" name="description" placeholder="Description" class="form-control">{{ old('description', $medicine->description) }}</textarea>
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
