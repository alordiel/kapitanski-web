<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MultipleUploadController;
use App\Http\Controllers\ExamController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/v1/file-upload', [MultipleUploadController::class, 'store'])->middleware(['auth:sanctum','abilities:upload-images']);
Route::post('/v1/save-questions', [ExamController::class, 'manageQuestions'])->middleware(['auth:sanctum','abilities:save-exam']);
Route::post('/v1/get-questions', [ExamController::class, 'getExamQuestions'])->middleware(['auth:sanctum','abilities:get-exam']);
Route::post('/v1/get-demo-questions', [ExamController::class, 'getDemoExamQuestions']);
