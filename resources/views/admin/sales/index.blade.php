@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Sales List</h2>
        <a class="btn btn-primary" href="{{ route('sales.create') }}">Create Sale</a>
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
                     
                     
                    <div class="table-responsive">
                        <table class="table" id='myTable'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Medicine</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Invoice Number</th>
                                    <th>Sold By</th>
                                    <th>Sold At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->stock->medicine->name }}</td>
                                        <td>{{ $sale->unit_price }}</td>
                                        <td>{{ $sale->quantity }}</td>
                                        <td>{{ $sale->total_price }}</td>
                                        <td>{{$sale->invoice_number}}</td>
                                        <td>{{ $sale->user->name }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No sales found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
