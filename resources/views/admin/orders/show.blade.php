@extends('admin.layouts.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{ $orders->id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    @include('admin.message')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header pt-3">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <h1 class="h5 mb-3">Shipping Address</h1>
                                    <address>
                                        <strong>{{ $orders->name }}</strong><br>
                                        Address: {{ $orders->address }}<br>
                                        Phone: {{ $orders->phone_number }}<br>
                                        Email: {{ $orders->email }}
                                    </address>
                                </div>



                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #007612</b><br>
                                    <br>
                                    <b>Order ID:</b> {{ $orders->id }}<br>
                                    <b>Total:</b> {{ number_format($orders->total_price, 0, ',', '.') }} ₫<br>
                                    <b>Status:</b> <span class="text-success">{{ $orders->status }}</span>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th width="100">Price</th>
                                        <th width="100">Qty</th>
                                        <th width="100">Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($orders->details as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ number_format($item->pivot->price, 0, ',', '.') }} ₫</td>
                                            <td>{{ $item->pivot->quantity }}</td>
                                            <td>{{ number_format($item->pivot->price * $item->pivot->quantity + $item->pivot->tax, 0, ',', '.') }}
                                                ₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.orders.update', $orders) }}" method="post">

                                <h2 class="h4 mb-3">Order Status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control" @disabled($orders->status == 'cancelled')>
                                        @php
                                            $status = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                                        @endphp

                                        @foreach ($status as $item)
                                            <option value="{{ $item }}"
                                                {{ $orders->status == $item ? 'selected' : '' }}>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-primary" type="submit"
                                        @disabled($orders->status == 'cancelled')>Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Send Inovice</h2>
                            <div class="mb-3">
                                <a href="{{ route('orders.export', $orders->id) }}" class="btn btn-primary">export</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
