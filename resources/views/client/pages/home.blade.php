@extends('client.layouts.master')

@section('title')
    Home
@endsection

@section('content')
    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner">
                @if ($sliders->isNotEmpty())
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <picture>
                                <source media="(max-width: 799px)"
                                    srcset="{{ asset('client-assets/images/carousel-1-m.jpg') }}" />
                                <source media="(min-width: 800px)"
                                    srcset="{{ asset('images/banners/' . $slider->image_url) }}" />
                                <img src="{{ asset('images/banners/' . $slider->image_url) }}" alt="" />
                            </picture>

                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3">
                                    <h1 class="display-4 text-white mb-3">{{ $slider->title }}</h1>
                                    <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                                        stet amet
                                        amet ndiam elitr ipsum diam</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ $slider->link }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>SẢN PHẨM NỔI BẬT</h2>
            </div>
            <div class="row pb-3">
                @if ($isProductFeatured->isNotEmpty())
                    @foreach ($isProductFeatured as $product)
                        @php
                            $outOfStock = $product->qty == 0 ? '<p class="out-of-stock">Hết hàng</p>' : '';
                            $disabled = $product->qty == 0 ? 'disabled' : '';
                        @endphp

                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card product-card">
                                {!! $outOfStock !!}
                                <div class="product-image position-relative">
                                    <a href="{{ route('product-detail', $product->slug) }}" class="product-img"><img
                                            class="card-img-top"
                                            src="{{ asset('images/products/' . $product->galleries->first()->image) }}"
                                            alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <button type="button" {{ $disabled }} class="btn btn-dark"
                                            onclick="addToCart({{ $product->id }})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3 dots">
                                    <a class="h6 link"
                                        href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                    <div class="price mt-2">
                                        <span
                                            class="h5"><strong>{{ number_format($product->price_sale ?? $product->price, 0, ',', '.') }}₫</strong></span>
                                        <span
                                            class="h6 text-underline"><del>{{ $product->price_sale ? number_format($product->price, 0, ',', '.' . '₫') : '' }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>SẢN PHẨM MỚI NHẤT</h2>
            </div>
            <div class="row pb-3">
                @if ($latest->isNotEmpty())
                    @foreach ($latest as $item)
                        @php
                            $outOfStock = $product->qty == 0 ? '<p class="out-of-stock">Hết hàng</p>' : '';
                            $disabled = $product->qty == 0 ? 'disabled' : '';
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card product-card">
                                {!! $outOfStock !!}
                                <div class="product-image position-relative">
                                    <a href="{{ route('product-detail', $item->slug) }}" class="product-img"><img
                                            class="card-img-top"
                                            src="{{ asset('images/products/' . $item->galleries->first()->image) }}"
                                            alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <button type="button" {{ $disabled }} class="btn btn-dark"
                                            href="javascript:void(0)" onclick="addToCart({{ $item->id }})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3 dots">
                                    <a class="h6 link"
                                        href="{{ route('product-detail', $item->slug) }}">{{ $item->title }}</a>
                                    <div class="price mt-2">
                                        <span
                                            class="h5"><strong>{{ number_format($product->price_sale ?? $product->price, 0, ',', '.') }}₫</strong></span>
                                        <span
                                            class="h6 text-underline"><del>{{ $product->price_sale ? number_format($product->price, 0, ',', '.' . '₫') : '' }}</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>SẢN PHẨM GIẢM GIÁ </h2>
            </div>
            <div class="row pb-3">
                @if ($productPriceSale->isNotEmpty())
                    @foreach ($productPriceSale as $value)
                        @php
                            $outOfStock = $product->qty == 0 ? '<p class="out-of-stock">Hết hàng</p>' : '';
                            $disabled = $product->qty == 0 ? 'disabled' : '';
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 ">
                            <div class="card product-card">
                                {!! $outOfStock !!}
                                <div class="product-image position-relative">
                                    <a href="{{ route('product-detail', $value->slug) }}" class="product-img"><img
                                            class="card-img-top"
                                            src="{{ asset('images/products/' . $value->galleries->first()->image) }}"
                                            alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <button type="button" {{ $disabled }} class="btn btn-dark"
                                            href="javascript:void(0)" onclick="addToCart({{ $value->id }})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3 dots">
                                    <a class="h6 link"
                                        href="{{ route('product-detail', $value->slug) }}">{{ $value->title }}</a>
                                    <div class="price mt-2">
                                        <span
                                            class="h5"><strong>{{ number_format($value->price_sale, 0, ',', '.') }}₫</strong></span>
                                        <span class="h6 text-underline"><del>{{ number_format($value->price, 0, ',', '.') }}
                                                ₫</del></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>


@endsection

@section('scripts')
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function addToCart(productId, quantity = 1) {
            $.ajax({
                type: "POST",
                url: "{{ route('cartAdd') }}",
                data: {
                    productId,
                    quantity
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
