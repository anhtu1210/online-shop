<header class="bg-dark" id="navbar">
    <div class="container">
        <nav class="navbar navbar-expand-xl">
            <a href="index.php" class="text-decoration-none mobile-logo">
                <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                <span class="h2 text-uppercase text-white px-2">SHOP</span>
            </a>
            <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                <i class="navbar-toggler-icon fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (getCategories()->isNotEmpty())
                        @foreach (getCategories() as $category)
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button"
                                    id="categoryDropdown{{ $category->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $category->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark"
                                    aria-labelledby="categoryDropdown{{ $category->id }}">
                                    @if ($category->children->isNotEmpty())
                                        @foreach ($category->children as $child)
                                            <li>
                                                <a class="dropdown-item nav-link"
                                                    href="{{ route('shop', $child->slug) }}">{{ $child->name }}</a>
                                                @if ($child->children->isNotEmpty())
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        @foreach ($child->children as $grandchild)
                                                            <li><a class="dropdown-item nav-link"
                                                                    href="{{ route('shop', $grandchild->slug) }}">{{ $grandchild->name }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </div>
            <div class="right-nav py-0">
                <a href="{{ route('cartShow') }}" class="ml-3 d-flex pt-2 btn-cart">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="rounded-circle">{{ Cart::content()->count() ?? 0 }}</span>
                </a>
            </div>
        </nav>
    </div>
</header>
