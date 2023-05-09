<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ExamController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth','role:super-admin'])->name('admin');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

// Serves all 3 roles the student, the partner, and the admin
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/products',[ProductController::class,'index'])->middleware(['auth','role:super-admin'])->name('product.index');
Route::post('/admin/products',[ProductController::class,'store'])->middleware(['auth','role:super-admin']);
Route::get('/admin/products/create',[ProductController::class,'create'])->middleware(['auth','role:super-admin']);
Route::get('/admin/products/{product}/edit',[ProductController::class,'edit'])->middleware(['auth','role:super-admin']);
Route::put('/admin/products/{product}',[ProductController::class,'update'])->middleware(['auth','role:super-admin']);
Route::delete('/admin/products/{product}',[ProductController::class,'destroy'])->middleware(['auth','role:super-admin']);
Route::get('/admin/products/{product}',[ProductController::class,'show'])->middleware(['auth','role:super-admin']);


Route::get('/posts',[PostController::class,'index'])->name('posts');
Route::get('/posts/{post:slug}',[PostController::class,'show']);
Route::get('/admin/posts',[PostController::class,'manage'])->middleware(['auth','role:super-admin'])->name('post.index');
Route::post('/admin/posts',[PostController::class,'store'])->middleware(['auth','role:super-admin']);
Route::get('/admin/posts/create',[PostController::class,'create'])->middleware(['auth','role:super-admin']);
Route::get('/admin/posts/{post}/edit',[PostController::class,'edit'])->middleware(['auth','role:super-admin']);
Route::put('/admin/posts/{post}',[PostController::class,'update'])->middleware(['auth','role:super-admin']);
Route::delete('/admin/posts/{post}',[PostController::class,'destroy'])->middleware(['auth','role:super-admin']);



Route::get('/admin/exams',[ExamController::class,'index'])->middleware(['auth','role:super-admin'])->name("exam.index");
Route::post('/admin/exams',[ExamController::class,'store'])->middleware(['auth','role:super-admin']);
Route::get('/admin/exams/create',[ExamController::class,'create'])->middleware(['auth','role:super-admin']);
Route::get('/admin/exams/{exam}/edit',[ExamController::class,'edit'])->middleware(['auth','role:super-admin']);
Route::put('/admin/exams/{exam}',[ExamController::class,'update'])->middleware(['auth','role:super-admin']);
Route::delete('/admin/exams/{exam}',[ExamController::class,'destroy'])->middleware(['auth','role:super-admin']);
Route::get('/admin/exams/{exam}',[ExamController::class,'show'])->middleware(['auth','role:super-admin']);


require __DIR__.'/auth.php';
