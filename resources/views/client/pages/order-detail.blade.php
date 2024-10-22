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
                        <div class="card-header d-flex justify-content-between">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                            @if ($order->status == 'pending')
                                <a id="order-cancel" href="#" class="btn btn-outline-dark ml-3">Cancel</a>
                            @endif
                        </div>

                        <div class="card-body pb-0">
                            <!-- Info -->
                            <div class="card card-sm">
                                <div class="card-body bg-light mb-3">
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order No:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                {{ $order->id }}
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Shipped date:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time datetime="2019-10-01">
                                                    {{ \Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}
                                                </time>
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Status:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                {{ $order->status }}
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                {{ number_format($order->total_price, 0, ',', '.') }} ₫
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">

                            <!-- Heading -->
                            <h6 class="mb-7 h5 mt-4">Order Items ({{ $order->details->count() }})</h6>

                            <!-- Divider -->
                            <hr class="my-3">

                            <!-- List group -->
                            <ul>
                                @php($subtotal = 0)
                                @foreach ($order->details as $detail)
                                    @php($subtotal += $detail->pivot->price * $detail->pivot->quantity + $detail->pivot->tax)
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-3 col-xl-2">
                                                <!-- Image -->
                                                <a href="product.html"><img
                                                        src="{{ asset('images/products/' . $detail->galleries->first()->image) }}"
                                                        alt="..." class="img-fluid"></a>
                                            </div>
                                            <div class="col">
                                                <!-- Title -->
                                                <p class="mb-4 fs-sm fw-bold">
                                                    <a class="text-body"
                                                        href="{{ route('product-detail', $detail->slug) }}">{{ $detail->title }}
                                                        <small>x
                                                            {{ $detail->pivot->quantity }}</small>
                                                    </a>
                                                    <br>
                                                    <span
                                                        class="text-muted">{{ number_format($detail->pivot->price, 0, ',', '.') }}₫</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <div class="card card-lg mb-5 mt-3">
                        <div class="card-body">
                            <!-- Heading -->
                            <h6 class="mt-0 mb-3 h5">Order Total</h6>

                            <!-- List group -->
                            <ul>
                                <li class="list-group-item d-flex">
                                    <span>Subtotal</span>
                                    <span class="ms-auto">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Voucher</span>
                                    <span class="ms-auto">{{ number_format($order->amount_coupon, 0, ',', '.') }}₫</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Shipping</span>
                                    <span class="ms-auto">{{ number_format($order->amount_shipping, 0, ',', '.') }}₫</span>
                                </li>
                                <li class="list-group-item d-flex fs-lg fw-bold">
                                    <span>Total</span>
                                    <span class="ms-auto">{{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#order-cancel').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('order-cancel', $order->id) }}";
                    }
                })
            });
        });
    </script>
@endsection
