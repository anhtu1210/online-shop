@extends('client.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('content')
    @include('client.components.breadcrumd', ['title' => 'Cart', 'category' => null])

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($subtotal = 0)
                                @forelse ($carts as $cart)
                                    @php($subtotal += $cart->price * $cart->qty  + $cart->tax)
                                    <tr>
                                        <td>
                                            <div class="">
                                                <img src="{{ asset('images/products/' . $cart->options->product_image->image) }}"
                                                    width="" height="">
                                                <h2 class="dots"></h2>
                                            </div>
                                        </td>
                                        <td>

                                            {{ number_format($cart->price, 0, ',', '.') }} ₫

                                        </td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button data-rowId="{{ $cart->rowId }}"
                                                        class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 minus">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input data-rowId="{{ $cart->rowId }}" type="text"
                                                    class="form-control form-control-sm  border-0 text-center"
                                                    value="{{ $cart->qty }}" id="qty-value">
                                                <div class="input-group-btn">
                                                    <button data-rowId="{{ $cart->rowId }}"
                                                        class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 plus">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="subtotal-{{ $cart->rowId }}">
                                            {{ number_format($cart->subtotal + $cart->tax, 0, ',', '.') }} ₫
                                        </td>
                                        <td>
                                            <button onclick="removeCart('{{ $cart->rowId }}')"
                                                class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5">Không có sản phẩm</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Tóm tắt giỏ hàng</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div id="total">{{ number_format($subtotal, 0, ',', '.') }} ₫</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{ $carts->isEmpty() ? 'javascript:void(0)' : route('checkout') }}"
                                    class="btn-dark btn btn-block w-100">Tiến hành thanh toán</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function removeCart(rowId) {
            $.ajax({
                url: "{{ route('cartDestroy') }}",
                type: "POST",
                data: {
                    rowId: rowId
                },
                success: function(response) {
                    if (response.status) {
                        var carts = response.carts;
                        $('tbody').empty();

                        var _html = "";

                        var _subTotal = 0;
                        if (carts.length == 0) {
                            _html = '<tr><td colspan="5">Không có sản phẩm</td></tr>';
                        } else {
                            $.each(carts, function(index, value) {
                                _subTotal += value.price * value.qty;
                                _html += /*html*/ `
                                <tr>
                                    <td><img src="{{ asset('images/products/${value.options.product_image.image}') }}"/></td>
                                    <td>${value.price.toString().replace(
                                        /\B(?=(\d{3})+(?!\d))/g, '.') +' ₫'}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button data-rowId="${value.rowId}"
                                                        class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 minus">
                                                            <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input data-rowId="${value.rowId}" type="text"
                                                class="form-control form-control-sm  border-0 text-center"
                                                    value="${value.qty}" id="qty-value">
                                            <div class="input-group-btn">
                                                <button data-rowId="${value.rowId}"
                                                        class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 plus">
                                                            <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${(parseInt(value.subtotal) + parseInt(value.tax)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +' ₫'}</td>
                                    <td><a href="javascript:void(0)" onclick="removeCart('${value.rowId}')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                                </tr>
                          `
                            })
                        }

                        $('tbody').html(_html);

                        $('#total, #subtotal_total').text(_subTotal.toString().replace(
                            /\B(?=(\d{3})+(?!\d))/g, '.') + ' ₫');

                        $('.btn-cart .rounded-circle').html(response.count);

                    }
                }
            })
        }

        $(document).on('change', '#qty-value', function() {
            var qty = $(this).val();

            if (qty > 10) {
                $(this).val(10);
                alert('Không được vượt quá 10 sản phẩm');
            }

            if (qty < 1) {
                $(this).val(1);
                alert('Không được nhỏ hơn 1 sản phẩm');
            }

            if (isNaN(qty)) {
                $(this).val(1);
                alert('Vui lòng nhập số');
            }

            updateCart($(this).data('rowid'), $(this).val());


        });

        $('body').on('click', '.minus', function() {
            var rowId = $(this).data('rowid');
            var qtyElements = $(this).parent().next();
            var qtyValue = parseInt(qtyElements.val());

            if (qtyValue <= 10 && qtyValue > 1) {
                qtyElements.val(qtyValue - 1);
                updateCart(rowId, qtyElements.val());
            }
        })

        $('body').on('click', '.plus', function() {
            var rowId = $(this).data('rowid');
            var qtyElements = $(this).parent().prev();
            var qtyValue = parseInt(qtyElements.val());

            if (qtyValue > 0 && qtyValue < 10) {
                qtyElements.val(qtyValue + 1);
                updateCart(rowId, qtyElements.val());
            }
        })

        function updateCart(rowId, quantity = 1) {
            $.ajax({
                url: "{{ route('cartUpdate') }}",
                method: "POST",
                data: {
                    rowId,
                    quantity
                },
                dataType: 'json',
                success: function(data) {
                    var _subtotal = 0;
                    var _total = 0
                    var cartArray = Object.values(data.carts);

                    cartArray.forEach(function(value) {
                        _total += (parseInt(value.subtotal) + parseInt(value.tax));

                        if (rowId == value.rowId) {
                            _subtotal += (parseInt(value.subtotal) + parseInt(value.tax));
                            $(`#subtotal-${rowId}`).html(_subtotal.toString().replace(
                                    /\B(?=(\d{3})+(?!\d))/g, '.') +
                                ' ₫');
                        }
                    });

                    $('#total').html(_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') +
                        ' ₫');
                },
                error(xhr, status, error) {
                    console.log(error);
                }
            })
        }
    </script>
@endsection
