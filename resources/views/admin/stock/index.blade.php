@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Stock List</h2>
        <a class="btn btn-primary" href="{{ route('stocks.create') }}">Add Stock</a>
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
                    <div class="title"><strong>Stocks</strong></div>
                    <div class="table-responsive">
                        <table class="table" i="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pharmacy</th>
                                    <th>Medicine</th>

                                    <th>Quantity</th>
                                    <th>Unit price</th>
                                    <th>Total Price</th>
                                    <th>Type</th>
                                    <th>Stock</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td>{{ $stock->id }}</td>
                                        <td>{{ $stock->pharmacy->name }}</td>
                                        <td>{{ $stock->medicine->name }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->unit_price }}</td>
                                        <td>{{ $stock->unit_price * $stock->quantity}}</td>

                                        <td>{{ ucfirst($stock->type) }}</td>
                                        <td>
                                            @if($stock->pharmacy->id=="1")
                                            {{$stock->remaining_quantity}}
                                            @else
                                          
                                            {{ $stock->total_quantity }}
                                            @endif
                                            
                                           
                                        </td>
                                        <td>{{ $stock->created_at }}</td>
                                        <td>
                                            <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this stock?');">Delete</button>
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
