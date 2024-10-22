@extends('client.layouts.master')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{ route('pocess-checkout') }}" method="post" id="checkout-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="name" value="{{ auth()->user()->name }}"
                                                id="first_name" class="form-control" placeholder="First Name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" value="{{ auth()->user()->email }}" name="email"
                                                id="email" class="form-control" placeholder="Email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="address" id="address" class="form-control">
                                                <option value="" disabled selected>Địa chỉ</option>
                                                @if ($cities->isNotEmpty())
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text"
                                                value="{{ old('phone_number', auth()->user()->phone_number) }}"
                                                name="phone_number" id="mobile" class="form-control"
                                                placeholder="Mobile No.">
                                            @error('phone_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" name="node" id="order_notes" cols="30" rows="2"
                                                placeholder="Order Notes (optional)" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>

                        <div class="input-group apply-coupan mb-3">
                            <input type="text" placeholder="Coupon Code" name="code" class="form-control"
                                id="coupon-code">
                            <button class="btn btn-dark" type="button" id="apply-coupan">Áp dụng</button>
                        </div>
                        <div class="card cart-summery shadow-lg mb-3">
                            <div class="card-body">
                                @php($subtotal = 0)
                                @foreach (Cart::content() as $item)
                                    @php($subtotal += $item->subtotal + $item->tax)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6 dots w-75"><small>x{{ $item->qty }} |
                                            </small>{{ $item->name }}
                                        </div>
                                        <div class="h6">
                                            {{ number_format($item->price * $item->qty + $item->tax, 0, ',', '.') }} ₫
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>{{ number_format($subtotal, 0, ',', '.') }} ₫</strong>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Coupon</strong></div>
                                    <div class="h6"><strong id="amount-coupon">-0 ₫</strong></div>
                                    <input type="hidden" name="amount_coupon" value="0" id="amount-coupon-input">
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6" id="amount-shipping"><strong>0 ₫</strong></div>
                                    <input type="hidden" name="amount_shipping" id="amount-shipping-input"
                                        value="0">
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong
                                            id="total">{{ number_format($subtotal, 0, ',', '.') }} ₫</strong></div>
                                    <input type="hidden" name="total" value="0" id="total-input">
                                </div>

                            </div>
                        </div>
                        <div class="card cart-summery">
                            <div class="mb-3">
                                <label for="" class="form-label">Payment Type</label>
                                <select name="payment_status" class="form-select">
                                    <option value="cod" @checked(old('payment_status', 'cod'))>Thanh toán khi giao hàng
                                    </option>
                                    <option value="paypal" @checked(old('payment_status', 'paypal'))>Thanh toán PayPal</option>
                                </select>
                                @error('payment_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn-dark btn btn-block w-100" id="pay-now-btn"
                                name="redirect" value="redirect">Pay
                                Now</button>
                        </div>
                        <!-- CREDIT CARD FORM ENDS HERE -->
                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        let isChanged = false;
        let isPayNowClicked = false;

        $("#address").change(function() {
            isChanged = true;
            let city_id = $(this).val();

            let coupon_code = $("#coupon-code").val();

            callApi(city_id, coupon_code);
        });

        $('#apply-coupan').click(function() {
            isChanged = true;

            let city_id = $("#address").val();

            let coupon_code = $("#coupon-code").val();

            callApi(city_id, coupon_code);
        });

        $('#pay-now-btn').click(function() {
            isPayNowClicked = true;
        });

        function callApi(city_id, coupon_code = null) {
            $.ajax({
                type: "POST",
                url: "{{ route('get-amount') }}",
                data: {
                    city_id,
                    coupon_code
                },
                success: function(response) {
                    $("#amount-shipping").html(response.shipping_amount);

                    $('#amount-coupon').html(response.discount_amount);

                    $("#total").html(response.grand_total);

                    $("#total-input").val(parseInt((response.grand_total).replace(/[,.đ]/g, ''), 10));

                    $("#amount-shipping-input").val(parseInt((response.shipping_amount).replace(/[,.đ]/g, ''),
                        10));

                    $("#amount-coupon-input").val(parseInt((response.discount_amount).replace(/[,.đ]/g, ''),
                        10));
                }
            });
        }

        window.addEventListener('beforeunload', function(e) {
            if (isChanged && !isPayNowClicked) {
                const confirmationMessage =
                    'Bạn có chắc chắn muốn rời khỏi trang này? Mọi thay đổi sẽ không được lưu.';

                e.returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });

        $('#checkout-form').on('submit', function() {
            isPayNowClicked = true;
        });
    </script>
@endsection
