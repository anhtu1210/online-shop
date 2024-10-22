<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', env('APP_NAME'))</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    </meta>


    <link rel="stylesheet" type="text/css" href="{{ asset('client-assets/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client-assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client-assets/css/video-js.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('client-assets/css/style.css?v=' . rand(111, 999) . ' ') }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('styles')
</head>

<body data-instant-intensity="mousedown">

    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                <div class="col-lg-4 logo">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                        <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                    @if (Auth::check())
                        <a href="{{route('profile')}}" class="nav-link text-dark">My Account</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-dark">Login</a>
                        <a href="{{ route('register') }}" class="nav-link text-dark">Register</a>
                    @endif
                    <form action="">
                        <div class="input-group">
                            <input type="text" placeholder="Search For Products" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Start Header --}}
    @include('client.layouts.header')
    {{-- End Header --}}


    <main>
        @yield('content')
    </main>

    {{--  Start Footer --}}
    @include('client.layouts.footer')
    {{-- End Footer --}}

    <div id="scroll-top" onclick="topFunction()">
        <i class="fas fa-angle-up"></i>
    </div>

    <script src="{{ asset('client-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('client-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('client-assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('client-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('client-assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('client-assets/js/custom.js') }}"></script>
    <script>
        // Get the button:
        let mybutton = document.getElementById("scroll-top");

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        window.onscroll = function() {
            myFunction()
            scrollFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("fixed-top");
            } else {
                navbar.classList.remove("fixed-top");
            }
        }


        const formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            minimumFractionDigits: 0
        });
    </script>

    @yield('scripts')
</body>

</html>
