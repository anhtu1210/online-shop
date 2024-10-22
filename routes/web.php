<?php

use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\DiscountController as AdminDiscountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('image', function () {
    return view('image');
});

Route::post('image', function (Request $request) {
    if ($request->hasFile('image')) {
        // Xác thực loại file là ảnh (tùy chọn)
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        // Nhận file ảnh từ request
        $file = $request->file('image');

        // Khởi tạo ImageManager với driver 'gd' (hoặc 'imagick' nếu bạn cài đặt Imagick)
        $manager = new ImageManager(new Driver()); // Hoặc 'imagick'

        // Tạo một instance của ảnh vừa upload
        $img = $manager->read($file->getRealPath());

        // Cắt ảnh thành kích thước 150x150
        $img->resize(150, 150);

        // Đặt tên file mới (sử dụng thời gian hiện tại để tránh trùng tên)
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Lưu ảnh vào storage bằng Storage::put
        Storage::put('uploads/' . $filename, (string) $img->encode());

        // Lấy đường dẫn URL để lưu vào database (sử dụng Storage::url)
        $imageUrl = Storage::url('uploads/' . $filename);

        // Trả về đường dẫn ảnh hoặc lưu vào database
        return response()->json(['url' => $imageUrl]);
    }

    return 'Không có ảnh nào được tải lên!';
})->name('image.upload');



Route::group(['prefix' => 'admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    // });

    Route::group(['middleware' => 'admin.auth'], function () {

        // dashboard routes
        Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

        // logout routes
        Route::get('logout', [HomeController::class, 'logout'])->name('admin.logout');

        // users routes
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('users/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/destroy', [UserController::class, 'destroy'])->name('admin.users.destroy');


        // products routes
        Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('products/destroy', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // categories routes
        Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('categories/update', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('categories/destroy', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        // Brands routes
        Route::get('brands', [BrandController::class, 'index'])->name('admin.brands.index');
        Route::get('brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('admin.brands.store');
        Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
        Route::put('brands/update', [BrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('brands/destroy', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

        // permissions routes
        Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::put('permissions/update', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('permissions/destroy', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

        // roles routes
        Route::get('roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('roles/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');

        // shipping routes
        Route::get('shipping/create', [ShippingController::class, 'create'])->name('admin.shipping.create');
        Route::post('shipping', [ShippingController::class, 'store'])->name('admin.shipping.store');
        Route::get('shipping/{id}/edit', [ShippingController::class, 'edit'])->name('admin.shipping.edit');
        Route::put('shipping/{id}', [ShippingController::class, 'update'])->name('admin.shipping.update');
        Route::delete('shipping/{id}', [ShippingController::class, 'destroy'])->name('admin.shipping.destroy');

        // discount coupons routes
        Route::get('coupons', [DiscountController::class, 'index'])->name('admin.coupons.index');
        Route::get('coupons/create', [DiscountController::class, 'create'])->name('admin.coupons.create');
        Route::post('coupons', [DiscountController::class, 'store'])->name('admin.coupons.store');
        Route::get('coupons/{id}/edit', [DiscountController::class, 'edit'])->name('admin.coupons.edit');
        Route::put('coupons/{id}', [DiscountController::class, 'update'])->name('admin.coupons.update');
        Route::delete('coupons/{id}', [DiscountController::class, 'destroy'])->name('admin.coupons.destroy');

        // orders routes
        Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('orders/{id}/details', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('/orders/export-all', [OrderController::class, 'exportAllInvoices'])->name('orders.export.all');
        Route::get('/orders/{id}/export', [OrderController::class, 'exportInvoice'])->name('orders.export');

        // banners routes
        Route::get('banners', [BannerController::class, 'index'])->name('admin.banners.index');
        Route::get('banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
        Route::post('banners', [BannerController::class, 'store'])->name('admin.banners.store');
        Route::get('banners/{banner}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
        Route::put('banners/{banner}', [BannerController::class, 'update'])->name('admin.banners.update');
        Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
    });
});

Route::get('/', [HomePageController::class, 'home'])->name('home');

// shop routes
Route::get('danhmuc/{slug?}', [ShopPageController::class, 'shop'])->name('shop');

// filter routes
Route::get('filter', [ShopPageController::class, 'filter'])->name('shop.filter');

// products-detail route

// cart routes
Route::get('gio-hang', [CartController::class, 'index'])->name('cartShow');
Route::post('add-to-cart', [CartController::class, 'store'])->name('cartAdd');
Route::post('xoa-gio-hang', [CartController::class, 'destroy'])->name('cartDestroy');
Route::post('cap-nhat-gio-hang', [CartController::class, 'update'])->name('cartUpdate');


Route::get('product/{slug}', [ProductDetailController::class, 'productDetail'])->name('product-detail');

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AccountController::class, 'login'])->name('login');
    Route::post('authenticate', [AccountController::class, 'authenticate'])->name('authenticate');

    Route::get('register', [AccountController::class, 'register'])->name('register');
    Route::post('pocess-register', [AccountController::class, 'pocessRegister'])->name('pocess-register');

    Route::get('verification-email/{email}', [AccountController::class, 'verificationEmail'])->name('verification-email');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AccountController::class, 'logout'])->name('logout');

    Route::get('profile', [AccountController::class, 'profile'])->name('profile');

    Route::get('my-orders', [AccountController::class, 'orders'])->name('my-orders');

    Route::get('order-cancel/{id}', [AccountController::class, 'orderCancel'])->name('order-cancel');

    Route::get('order-detail/{id}', [AccountController::class, 'orderDetail'])->name('order-detail');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::post('get-amount-address', [CheckoutController::class, 'getAmount'])->name('get-amount');

    Route::post('apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');

    Route::post('remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('remove-coupon');

    Route::post('pocess-checkout', [CheckoutController::class, 'pocessCheckout'])->name('pocess-checkout');

    Route::get('/vnpay-callback', [CheckoutController::class, 'vnpayCallback'])->name('vnpay.callback');

    Route::get('thank-you', [CheckoutController::class, 'thankYou'])->name('thank-you');
});
