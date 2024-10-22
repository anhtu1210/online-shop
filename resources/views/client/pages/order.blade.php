@extends('client.layouts.master')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">

            <div class="row">
                @include('client.components.sidebar')
                <div class="col-md-9">
                    @include('admin.message')
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Orders #</th>
                                            <th>Date Purchased</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($orders->isNotEmpty())
                                            @foreach ($orders as $order)
                                                @php
                                                    if ($order->status == 'pending') {
                                                        $order->status =
                                                            '<span class="badge bg-warning">Chờ xác nhận</span>';
                                                    } elseif ($order->status == 'processing') {
                                                        $order->status =
                                                            '<span class="badge bg-info">Đã xác nhận</span>';
                                                    } elseif ($order->status == 'shipped') {
                                                        $order->status =
                                                            '<span class="badge bg-primary">Đang giao hàng</span>';
                                                    } elseif ($order->status == 'delivered') {
                                                        $order->status =
                                                            '<span class="badge bg-success">Đã giao hàng</span>';
                                                    } else {
                                                        $order->status = '<span class="badge bg-danger">Đã hủy</span>';
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="{{ route('order-detail', $order->id) }}">{{ $order->id }}</a>
                                                    </td>
                                                    <td>{{ $order->created_at->toDayDateTimeString() }}</td>
                                                    <td>
                                                        {!! $order->status !!}
                                                    </td>
                                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} ₫ </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="5">Không có đơn hàng</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
