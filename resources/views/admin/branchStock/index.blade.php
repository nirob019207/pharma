@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Stock List</h2>
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
                    <div class="title d-flex justify-content-between align-items-center">
                        <strong>Stocks</strong>
                        <form action="{{ route('brachStock.index') }}" method="GET" class="form-inline">
                            <input type="text" name="search" class="form-control" placeholder="Search Medicine" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary ml-2">Search</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Stock</th>
                                    
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->id }}</td>
                                        <td>{{ $stock->medicine->name }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->unit_price }}</td>
                                        <td>{{ $stock->quantity * $stock->unit_price }}</td>
                                        <td>{{ $stock->total_quantity }}</td>
                                        <td>{{ $stock->created_at }}</td>
                                        <td>
                                            <a href="{{route('sales.create')}}" class="bg-success p-2">Sales</a>
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
