<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeOptionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductRateController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CommentController as CommentHomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductController as ProductHomeController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\LoginAndLogoutController;
use App\Http\Controllers\Home\passwordResetController;
use App\Http\Controllers\Home\RegisterController;
use App\Http\Controllers\Home\UserAdressController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishlistController;
use Illuminate\Support\Facades\Route;

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
Route::prefix('/admin')-> name('admin.')-> group(function (){
    Route::get('/' , function (){
       return view('admin.dashboard');
    });
    Route::resource('attributes' , AttributeController::class);
    Route::resource('categories' , CategoryController::class);
    Route::resource('tags' , TagController::class);
    Route::resource('products' , ProductController::class);
    Route::resource('users' , UserController::class);
    Route::resource('roles' , RoleController::class);
    Route::resource('permissions' , PermissionController::class);
    Route::resource('coupons' , CouponController::class);

    Route::get('/products/{product}/edit_attributes' , [AttributeOptionController::class , 'edit'])->name('products.edit_attributes');
    Route::get('/products/{product}/edit_images' , [ProductImageController::class , 'edit'])->name('products.edit_images');
    Route::post('/products/add_image' , [ProductImageController::class , 'add'])->name('products.add_image');
    Route::post('/products/delete_image' , [ProductImageController::class , 'destroy'])->name('products.delete_image');
    Route::post('/products/set_primary' , [ProductImageController::class , 'setPrimary'])->name('products.set_primary');
    Route::post('/products/update_primary' , [ProductImageController::class , 'updatePrimaryImage'])->name('products.update_primary');

    Route::get('/comments/show/{comment}' , [CommentController::class , 'show'])->name('comments.show');
    Route::get('/comments/index' , [CommentController::class , 'index'])->name('comments.index');
    Route::delete('/comments/destroy/{comment}' , [CommentController::class , 'destroy'])->name('comments.destroy');
    Route::get('/comments/approve/{comment}' , [CommentController::class , 'changeApprove'])->name('comments.approve');
    Route::get('/rates/index' , [ProductRateController::class , 'index'])->name('rates.index');
    Route::delete('/rates/destroy/{product_rate}' , [ProductRateController::class , 'destroy'])->name('rates.destroy');

    Route::get('/orders/index' , [OrderController::class , 'index'])->name('orders.index');
    Route::get('/orders/show/{order}' , [OrderController::class , 'show'])->name('orders.show');
    Route::delete('/orders/destroy/{order}' , [OrderController::class , 'destroy'])->name('orders.destroy');

    Route::get('/transactions/show/{transaction}' , [TransactionController::class , 'show'])->name('transactions.show');
    Route::get('/transactions/index' , [TransactionController::class , 'index'])->name('transactions.index');
    Route::delete('/transactions/destroy/{transaction}' , [TransactionController::class , 'destroy'])->name('transactions.destroy');
});

Route::name('home.')->group(function (){
    Route::get('/' , [HomeController::class , 'index'])->name('index');
    Route::get('/products/{product:slug}' , [ProductHomeController::class , 'show'])->name('product.show');
    Route::get('/search/categories/{category:slug}' , [ProductHomeController::class , 'searchByCategory'])->name('product.search.category');
    Route::get('/search/tags/{tag:slug}' , [ProductHomeController::class , 'searchByTag'])->name('product.search.tag');
    Route::post('/products/setPrice/{product}' , [ProductHomeController::class , 'setPrice'])->name('product.setPrice');
    Route::post('/comments/store/{product}' , [CommentHomeController::class , 'store'])->name('comments.store');

    Route::get('/wishlist/{product}' , [WishlistController::class , 'add'])->name('wishlist.add');
    Route::get('/wishlist/destroy/{product}' , [WishlistController::class , 'destroy'])->name('wishlist.destroy');

    Route::get('/compare/show/{product}' , [CompareController::class , 'showComparePage'])->name('compare.showPage');
    Route::get('/compare/add/{product}' , [CompareController::class , 'add'])->name('compare.add');
    Route::get('/compare/destroy/{product}' , [CompareController::class , 'destroy'])->name('compare.destroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/remove-from-cart/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::get('/check-out', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/payment', [PaymentController::class, 'payment'])->name('payment.payment');
    Route::get('/payment_Verify_pay', [PaymentController::class, 'payVerify'])->name('payment.verify.pay');
    Route::post('/payment_Verify_idPay', [PaymentController::class, 'idPayVerify'])->name('payment.verify.idPay');
});

Route::prefix('profile')->name('home.profile.')->group(function ()
{
    Route::get('/', [UserProfileController::class, 'index'])->name('index');
    Route::put('/{user}', [UserProfileController::class, 'updateProfile'])->name('update');
    Route::get('/comments', [CommentHomeController::class, 'userComments'])->name('comments');
    Route::get('/wishlist' , [WishlistController::class , 'showWishlist'])->name('wishlist');
    Route::get('/addresses' , [UserAdressController::class , 'index'])->name('addresses.index');
    Route::post('/addresses' , [UserAdressController::class , 'store'])->name('addresses.store');
    Route::delete('/addresses/{user_address}' , [UserAdressController::class , 'destroy'])->name('addresses.destroy');
    Route::get('/addresses/{user_address}/edit' , [UserAdressController::class , 'edit'])->name('addresses.edit');
    Route::put('/addresses/{user_address}' , [UserAdressController::class , 'update'])->name('addresses.update');

//    Route::get('/comments', [HomeCommentController::class, 'usersProfileIndex'])->name('comments.users_profile.index');
//    Route::get('/wishlist', [WishlistController::class, 'usersProfileIndex'])->name('wishlist.users_profile.index');
//    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
//    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
//    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
//    Route::get('/orders', [CartController::class, 'usersProfileIndex'])->name('orders.users_profile.index');
});

//auth routs
Route::get('/login', [LoginAndLogoutController::class , 'index'])->name('login');
Route::post('/login', [LoginAndLogoutController::class , 'logIn'])->name('login.handle');
Route::post('/logout', [LoginAndLogoutController::class , 'logOut'])->name('logout');
Route::get('/register', [RegisterController::class , 'index'])->name('register');
Route::post('/register', [RegisterController::class , 'register'])->name('register.handle');
Route::get('/email-verify', [RegisterController::class , 'verifyNotice'])->middleware('auth')->name('verification.notice');
Route::get('/email-verify/{id}/{hash}', [RegisterController::class , 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email-verification-notification', [RegisterController::class , 'resendVerifyLink'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/forgot-password', [passwordResetController::class , 'forgetPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [passwordResetController::class , 'forgetPasswordHandle'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [passwordResetController::class , 'resetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [passwordResetController::class , 'resetPasswordHandle'])->middleware('guest')->name('password.update');
