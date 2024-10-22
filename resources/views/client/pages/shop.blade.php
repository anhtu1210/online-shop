@extends('client.layouts.master')

@section('title')
    Shop
@endsection

@section('content')
    @include('client.components.breadcrumd', ['title' => 'Shop', 'category' => $category])

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="d-flex justify-content-between">
                        <div class="sub-title">
                            <h2>Categories</h2>
                        </div>
                        <div class="reset-data">
                            <p id="reset-data" class="border rounded border-2 px-3">Reset</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories->isNotEmpty())
                                    <div class="accordion" id="accordionExample">
                                        @foreach ($categories as $key => $cat)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-{{ $key }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $key }}" aria-expanded="false"
                                                        aria-controls="collapse-{{ $key }}">
                                                        {{ $cat->name }}
                                                    </button>
                                                </h2>

                                                <div id="collapse-{{ $key }}" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-{{ $key }}"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($cat->children ?? [] as $child)
                                                                <a href="javascript:void(0)" id="category_id"
                                                                    data-id="{{ $child->id }}"
                                                                    class="nav-item nav-link">{{ $child->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input id="brand_id" class="form-check-input" type="radio" name="brand"
                                            value="{{ $brand->id }}" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h2>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="price-range">
                                <div class="input-container">
                                    <input type="number" id="min" value="1">
                                </div>
                                <div class="slider-container">
                                    <div id="slider"></div>
                                </div>
                                <div class="input-container">
                                    <input type="number" id="max" value="1000">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown">Phân loại</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item sort-price" href="javascript:void(0)"
                                                data-sort="desc">Giá
                                                cao</a>
                                            <a class="dropdown-item sort-price" href="javascript:void(0)"
                                                data-sort="asc">Giá
                                                thấp</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="productList" class="row">
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    @php
                                        $outOfStock = $product->qty == 0 ? '<p class="out-of-stock">Hết hàng</p>' : '';
                                        $disabled = $product->qty == 0 ? 'disabled' : '';
                                    @endphp
                                    <div class="col-xl-4 col-lg-6 col-md-6">
                                        <div class="card product-card">
                                            {!! $outOfStock !!}
                                            <div class="product-image position-relative">
                                                <a href="{{ route('product-detail', $product->slug) }}"
                                                    class="product-img"><img class="card-img-top img-fluid"
                                                        src="{{ asset('images/products/' . $product->galleries->first()->image) }}"
                                                        alt=""></a>
                                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                                <div class="product-action">
                                                    <button onclick="addToCart({{ $product->id }})" type="button"
                                                        {{ $disabled }} class="btn btn-dark" href="#">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body text-center mt-3 dots">
                                                <a class="h6 link"
                                                    href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>{{ number_format($product->price_sale ?? $product->price, 0, ',', '.') }}
                                                            ₫</strong></span>
                                                    <span
                                                        class="h6 text-underline"><del>{{ $product->price_sale ? number_format($product->price, 0, ',', '.') . ' ₫' : '' }}</del></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="col-md-12 pt-5" id="paginationLinks">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('client-assets/css/nouislider.min.css') }}">
@endsection

@section('scripts')
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('client-assets/js/nouislider.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var sortOrder = null;
            var category_id = null;
            var lastParams = {};

            var slider = document.getElementById('slider');
            var minValueInput = $('#min');
            var maxValueInput = $('#max');

            noUiSlider.create(slider, {
                start: [1, 1000],
                connect: true,
                range: {
                    'min': 1,
                    'max': 1000
                }
            });

            minValueInput.on('input', function() {
                slider.noUiSlider.set([$(this).val(), null]);
            });

            maxValueInput.on('input', function() {
                slider.noUiSlider.set([null, $(this).val()]);
            });

            slider.noUiSlider.on('update', function(values, handle) {
                var range = slider.noUiSlider.get();
                var minValue = Math.round(range[0]);
                var maxValue = Math.round(range[1]);

                minValueInput.val(minValue);
                maxValueInput.val(maxValue);
            });

            slider.noUiSlider.on('change', function() {
                fetchProducts();
            });


            function fetchProducts(page = 1, resetData = false) {
                var param = {
                    'page': page
                };

                if (!resetData) {
                    param['price_order'] = sortOrder;
                    param['min'] = $('#min').val();
                    param['max'] = $('#max').val();
                    param['brand_id'] = $('input[name="brand"]:checked').val();
                    param['category_id'] = category_id;
                } else {
                    $('#min').val(1);
                    $('#max').val(1000);
                    slider.noUiSlider.set([1, 1000]);
                    $('input[name="brand"]').prop('checked', false);
                    $('input[name="category"]').prop('checked', false);
                    sortOrder = null;
                    category_id = "{{ $category_id ?? null }}";
                }

                if (!compareObjects(param, lastParams)) {
                    $.ajax({
                        url: "{{ route('shop.filter') }}",
                        type: 'GET',
                        data: param,
                        success: function(response) {
                            $('.btn-cart .rounded-circle').html(response.count);
                            $('#productList').empty();
                            let _html = "";
                            $.each(response.data, function(index, product) {
                                console.log(product);
                                let outOfStock = product.qty == null ?
                                    '<p class="out-of-stock">Hết hàng</p>' : '';
                                let disabled = product.qty == null ? 'disabled' : '';

                                _html += /*html*/ `
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <div class="card product-card">
                                        ${outOfStock}
                                        <div class="product-image position-relative">
                                            <a href="product.php" class="product-img"><img class="card-img-top" src="{{ asset('images/products/') }}/${product.galleries[0].image}" alt=""></a>
                                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                            <div class="product-action">
                                                <button onclick="addToCart(${product.id})" type="button" ${disabled} class="btn btn-dark" href="#"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
                                            </div>
                                        </div>
                                        <div class="card-body text-center mt-3 dots">
                                            <a class="h6 link" href="product.php">${product.title}</a>
                                            <div class="price mt-2">
                                                <span
                                                    class="h5"><strong>${formatter.format(product.price_sale ?? product.price)}</strong></span>
                                                <span class="h6 text-underline"><del>${product.price_sale ? formatter.format(product.price) : ''}</del></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            });

                            $('#productList').html(_html);

                            $('#paginationLinks').html(response.links);

                            lastParams = {
                                ...param
                            };
                        },
                        error(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }

            // Hàm so sánh 2 đối tượng
            function compareObjects(obj1, obj2) {
                return JSON.stringify(obj1) === JSON.stringify(obj2);
            }


            $('input[name="brand"]').on('click', function() {
                fetchProducts();
            });

            $('.sort-price').on('click', function() {
                sortOrder = $(this).data('sort');
                fetchProducts();
            });

            $(document).on('click', '#category_id', function() {
                category_id = $(this).data('id');
                fetchProducts();
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchProducts(page);
            });

            $('#reset-data').on('click', function() {
                fetchProducts(1, true);
            });
        });

        function addToCart(id, quantity = 1) {
            $.ajax({
                type: "POST",
                url: "{{ route('cartAdd') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status) {
                        $('.btn-cart .rounded-circle').html(response.count);
                        Swal.fire({
                            title: "Good job!",
                            text: response.message,
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Good job!",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
