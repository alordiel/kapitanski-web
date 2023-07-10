<?php

use App\Http\Controllers\ExamTakingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/admin', static function () {
    return view('admin');
})->middleware(['auth', 'role:super-admin'])->name('admin');

Route::get('/about', static function () {
    return view('pages.about');
})->name('about');

Route::get('/buy', static function () {
    return view('pages.buy');
})->name('buy');

Route::get('/checkout/{plan?}', static function (string $plan = 'single') {
    return view('pages.checkout', ['plan' => $plan]);
})->name('checkout');

Route::post('/order', [OrderController::class,'store'])->name('new-order');

Route::get('/contacts', static function () {
    return view('pages.contacts');
})->name('contacts');

// Serves all 3 roles the student, the partner, and the admin
Route::get('/dashboard', static function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/exams', static function () {
        return view('exam.myExam');
    })->name('my-exam');
    Route::get('/statistics', static function () {
        return view('examTaking.myStats');
    })->name('my-statistics');
    Route::post('/subscription/activate', [SubscriptionController::class, 'activate'])->name('subscription.activate');
    Route::get('/my-subscriptions',[SubscriptionController::class,'showPersonal'])->name('subscription.personal');
    Route::get('/my-subscriptions/students/{order}', [SubscriptionController::class, 'manageStudents'])
        ->middleware(['permission:create-students'])
        ->name('subscription.students');
    Route::post('/my-subscriptions/students/store',[SubscriptionController::class, 'storeStudents'])
        ->middleware(['permission:create-students'])
        ->name('subscription.students.store');
});


// ADMIN ROUTES
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
    // Question categories
    Route::get('/admin/question-category', [QuestionCategoryController::class, 'index'])->name("questionCategory.manage");
    Route::post('/admin/question-category', [QuestionCategoryController::class, 'store'])->name("questionCategory.store");
    Route::get('/admin/question-category/create', [QuestionCategoryController::class, 'create'])->name("questionCategory.create");
    Route::get('/admin/question-category/{questionCategory}/edit', [QuestionCategoryController::class, 'edit'])->name("questionCategory.edit");
    Route::put('/admin/question-category/{questionCategory}', [QuestionCategoryController::class, 'update'])->name("questionCategory.update");
    Route::delete('/admin/question-category/{questionCategory}', [QuestionCategoryController::class, 'destroy'])->name("questionCategory.destroy");
    // Order Routes
    Route::get('/admin/order', [OrderController::class, 'index'])->name("order.manage");
    Route::post('/admin/order', [OrderController::class, 'adminStore'])->name("order.store");
    Route::get('/admin/order/create', [OrderController::class, 'create'])->name("order.create");
    Route::get('/admin/order/{order}/edit', [OrderController::class, 'edit'])->name("order.edit");
    Route::put('/admin/order/{order}', [OrderController::class, 'update'])->name("order.update");
    Route::delete('/admin/order/{order}', [OrderController::class, 'destroy'])->name("order.destroy");
    // Subscription Route
     Route::get('/admin/subscription', [SubscriptionController::class, 'index'])->name("subscription.manage");
    Route::post('/admin/subscription', [SubscriptionController::class, 'store'])->name("subscription.store");
    Route::get('/admin/subscription/create', [SubscriptionController::class, 'create'])->name("subscription.create");
    Route::get('/admin/subscription/{subscription}/edit', [SubscriptionController::class, 'edit'])->name("subscription.edit");
    Route::put('/admin/subscription/{subscription}', [SubscriptionController::class, 'update'])->name("subscription.update");
    Route::delete('/admin/subscription/{subscription}', [SubscriptionController::class, 'destroy'])->name("subscription.destroy");
    // Exam takings
    Route::get('/admin/exam-takings/',[ExamTakingController::class, 'index'])->name("examTaking.manage");
    Route::get('/admin/exam-taking/{examTaking}',[ExamTakingController::class,'show'])->name('examTaking.show');
    Route::delete('/admin/exam-taking/{examTaking}',[ExamTakingController::class,'destroy'])->name('examTaking.destroy');
});


Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('post');


require __DIR__ . '/auth.php';
