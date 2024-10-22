@extends('client.layouts.master')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('content')
    @include('client.components.breadcrumd', [
        'title' => 'shop',
        'category' => $product->title,
    ])

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if ($product->galleries->isNotEmpty())
                                @foreach ($product->galleries as $garlery)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img class="w-100 h-100" src="{{ asset('images/products/' . $garlery->image) }}"
                                            alt="Image">
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{ $product->title }}</h1>
                        <div class="d-flex mb-3 align-items-center">
                            <div class="star-rating" data-rating="4.5">
                                <div class="star">
                                    <span class="star-background">&#9733;</span>
                                    <span class="star-foreground">&#9733;</span>
                                </div>
                                <div class="star">
                                    <span class="star-background">&#9733;</span>
                                    <span class="star-foreground">&#9733;</span>
                                </div>
                                <div class="star">
                                    <span class="star-background">&#9733;</span>
                                    <span class="star-foreground">&#9733;</span>
                                </div>
                                <div class="star">
                                    <span class="star-background">&#9733;</span>
                                    <span class="star-foreground">&#9733;</span>
                                </div>
                                <div class="star">
                                    <span class="star-background">&#9733;</span>
                                    <span class="star-foreground">&#9733;</span>
                                </div>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        {{-- <h2 class="price text-secondary"><del>$400</del></h2> --}}
                        <h2 class="price ">{{ number_format($product->price, 0, ',', '.') }} ₫</h2>

                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil
                            iste porro ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus
                            voluptates dolorem nobis voluptatum qui, minus facere.</p>
                        <div class="input-group quantity mb-3" style="width: 120px">
                            <div class="input-group-btn">
                                <button data-id="{{ $product->id }}"
                                    class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input data-id="{{ $product->id }}" type="text"
                                class="form-control form-control-sm  border-0 text-center" value="1" id="qty-value">
                            <div class="input-group-btn">
                                <button data-id="{{ $product->id }}"
                                    class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button @disabled($product->qty == 0) onclick="addToCart({{ $product->id }})" class="btn btn-dark"><i
                                class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</button>
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                    aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                    type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                                    Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                    type="button" role="tab" aria-controls="reviews"
                                    aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis
                                    suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis
                                    alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet
                                    consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus
                                    earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint
                                    ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit,
                                    incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem.
                                    Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    @if ($relatedProducts->isNotEmpty())
                        @foreach ($relatedProducts as $item)
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="" class="product-img"><img class="card-img-top"
                                            src="{{ asset('images/products/' . $item->galleries->first()->image) }}"
                                            alt=""></a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>



                                    <div class="product-action">
                                        <a onclick="addToCart({{ $item->id }})" class="btn btn-dark"
                                            href="javascript:void(0)">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3 dots">
                                    <a class="h6 link" href="">{{ $item->title }}</a>
                                    <div class="price mt-2">
                                        <span
                                            class="h5"><strong>{{ number_format($item->price, 0, ',', '.') }}₫</strong></span>
                                        {{-- <span class="h6 text-underline"><del>$120</del></span> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.plus').click(function() {
            var qtyElements = $(this).parent().prev();
            var qtyValue = parseInt(qtyElements.val());
            if (qtyValue > 0 && qtyValue < 10) {
                qtyElements.val(qtyValue + 1);
            }
        })

        $('.minus').click(function() {
            var qtyElements = $(this).parent().next();
            var qtyValue = parseInt(qtyElements.val());
            if (qtyValue > 1) {
                qtyElements.val(qtyValue - 1);
            }
        })

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



        });

        function addToCart(productId, quantity = 1) {


            quantity = $('#qty-value').val();

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

        function setRatings() {
            const ratings = document.querySelectorAll('.star-rating');
            ratings.forEach(ratingElement => {
                const rating = parseFloat(ratingElement.getAttribute('data-rating'));
                const stars = ratingElement.querySelectorAll('.star');
                stars.forEach((star, index) => {
                    const percentage = Math.min(Math.max(rating - index, 0), 1) * 100;
                    star.querySelector('.star-foreground').style.width = `${percentage}%`;
                });
            });
        }

        // Set ratings for all star-rating elements
        setRatings();
    </script>
@endsection
