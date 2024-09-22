@extends('admin.index')
@section('content')
<div class="page-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Create Sale</h2>
    </div>
</div>

<section class="no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="block margin-bottom-sm">
                    <div class="title"><strong>Add Medicine</strong></div>
                    <div class="block-body">
                        <form action="{{ route('sales.addTempSale') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="stock_id">Medicine</label>
                                <select name="stock_id" id="stock_id" class="form-control">
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->medicine->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>

                <div class="block margin-bottom-sm">
                    <div class="title"><strong>Cart</strong></div>
                    <div class="block-body">
                        @php
                            $tempSales = \DB::table('temp_sales')->where('user_id', Auth::id())->get();
                        @endphp

                        @if($tempSales->isEmpty())
                            <p>No medicines in the cart.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tempSales as $tempSale)
                                        <tr>
                                            <td>{{ \App\Models\Stock::find($tempSale->stock_id)->medicine->name }}</td>
                                            <td>{{ $tempSale->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form action="{{ route('sales.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Submit All Sales</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
