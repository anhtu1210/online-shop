<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LARAVEL SHOP</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Premissions</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>Roles</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Role</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Categories</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.brands.index') }}" class="nav-link">
                        <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p>Brands</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Products</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>list Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-trash"></i>
                                <p>Trash Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Shipping</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.shipping.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add Shipping</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-percent"></i>
                        <p>Discount</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>list Discount</p>
                            </a>

                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add Discount</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Users</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>list User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="collapse">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Banner</p>
                        <i class="right fas fa-angle-right"></i>
                    </a>
                    <ul class="nav nav-treeview ml-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>list Banner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.banners.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add Banner</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
