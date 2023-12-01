<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeOptionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\TagController;
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

    Route::get('/products/{product}/edit_attributes' , [AttributeOptionController::class , 'edit'])->name('products.edit_attributes');
    Route::get('/products/{product}/edit_images' , [ProductImageController::class , 'edit'])->name('products.edit_images');
    Route::post('/products/add_image' , [ProductImageController::class , 'add'])->name('products.add_image');
    Route::post('/products/delete_image' , [ProductImageController::class , 'destroy'])->name('products.delete_image');
    Route::post('/products/set_primary' , [ProductImageController::class , 'setPrimary'])->name('products.set_primary');
    Route::post('/products/update_primary' , [ProductImageController::class , 'updatePrimaryImage'])->name('products.update_primary');
});
