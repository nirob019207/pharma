@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Create Stock</h2>
        <a class="btn btn-primary" href="{{ route('stocks.index') }}">View Stocks</a>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
        @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
            <div class="col-lg-8">
                <div class="block">
                    <div class="title"><strong>Add Stock</strong></div>
                    <div class="block-body">
                        <form method="POST" action="{{ route('stocks.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="pharmacy_id" class="sr-only">Pharmacy</label>
                                <select id="pharmacy_id" name="pharmacy_id" class="form-control">
                                    @foreach($pharmacies as $pharmacy)
                                        <option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id" class="sr-only">Medicine</label>
                                <select id="medicine_id" name="medicine_id" class="form-control">
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="sr-only">Quantity</label>
                                <input id="quantity" type="number" name="quantity" placeholder="Quantity" class="form-control" value="{{ old('quantity') }}">
                            </div>
                            <div class="form-group">
                                <label for="quantity" class="sr-only">Unit Price</label>
                                <input id="quantity" type="number" name="unit_price" placeholder="Unit Price" class="form-control" value="{{ old('quantity') }}">
                            </div>
                           
                            <div class="form-group">
                                <label for="type" class="sr-only">Type</label>
                                <select id="type" name="type" class="form-control">
                                    <option value="received">Received</option>
                                    <option value="supplied">Supplied</option>
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
