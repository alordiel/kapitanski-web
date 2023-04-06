<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing  

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hello', function () {
     return view('hello');
});


// LIST all products
Route::get( '/products', [ ProductController::class,'index' ] );

// Show form for creating new product
Route::get( '/products/create', [ ProductController::class, 'create' ] );
Route::post( '/products', [ ProductController::class, 'store' ] );