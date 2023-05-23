<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionCategoryController;
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
})->middleware(['auth', 'role:super-admin'])->name('admin');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/buy', function () {
    return view('pages.buy');
})->name('buy');

Route::get('/checkout/{plan?}', function (string $plan = 'single') {
    return view('pages.checkout', ['plan' => $plan]);
})->name('checkout');

Route::get('/contacts', function () {
    return view('pages.contacts');
})->name('contacts');

// Serves all 3 roles the student, the partner, and the admin
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:super-admin'])->group(function () {
    // User Routes
    Route::get('/admin/users', [ProfileController::class, 'adminIndex'])->name('user.admin.manage');
    Route::get('/admin/users/create', [ProfileController::class, 'adminCreate'])->name('user.admin.create');
    Route::post('/admin/users', [ProfileController::class, 'adminStore'])->name('user.admin.store');
    Route::get('/admin/users/{user}/edit', [ProfileController::class, 'adminEdit'])->name('user.admin.edit');
    Route::get('/admin/users/{user}', [ProfileController::class, 'adminShow'])->name('user.admin.show');
    Route::put('/admin/users/{user}', [ProfileController::class, 'adminUpdate'])->name('user.admin.update');
    Route::delete('/admin/users/{user}', [ProfileController::class, 'adminDestroy'])->name('user.admin.destroy');
    // Post Routes
    Route::get('/admin/posts', [PostController::class, 'manage'])->name('post.admin.manage');
    Route::post('/admin/posts', [PostController::class, 'store'])->name('post.admin.store');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('post.admin.create');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('post.admin.edit');
    Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('post.admin.update');
    Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('post.admin.destroy');
    // Exam Routes
    Route::get('/admin/exams', [ExamController::class, 'index'])->name("exam.admin.manage");
    Route::post('/admin/exams', [ExamController::class, 'store'])->name("exam.admin.store");
    Route::get('/admin/exams/create', [ExamController::class, 'create'])->name("exam.admin.create");
    Route::get('/admin/exams/{exam}/edit', [ExamController::class, 'edit'])->name("exam.admin.edit");
    Route::put('/admin/exams/{exam}', [ExamController::class, 'update'])->name("exam.admin.update");
    Route::delete('/admin/exams/{exam}', [ExamController::class, 'destroy'])->name("exam.admin.destroy");
    Route::get('/admin/exams/{exam}', [ExamController::class, 'show'])->name("exam.admin.show");
    Route::get('/admin/exams/{exam}/questions', [ExamController::class, 'questions'])->name("exam.admin.questions");

    Route::get('/admin/question-category', [QuestionCategoryController::class, 'index'])->name("questionCategory.manage");
    Route::post('/admin/question-category', [QuestionCategoryController::class, 'store'])->name("questionCategory.store");
    Route::get('/admin/question-category/create', [QuestionCategoryController::class, 'create'])->name("questionCategory.create");
    Route::get('/admin/question-category/{questionCategory}/edit', [QuestionCategoryController::class, 'edit'])->name("questionCategory.edit");
    Route::put('/admin/question-category/{questionCategory}', [QuestionCategoryController::class, 'update'])->name("questionCategory.update");
    Route::delete('/admin/question-category/{questionCategory}', [QuestionCategoryController::class, 'destroy'])->name("questionCategory.destroy");
});


Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('post');


require __DIR__ . '/auth.php';
