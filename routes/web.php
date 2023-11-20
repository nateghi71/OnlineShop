<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
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
});
