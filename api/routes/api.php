<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RivistaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// AUTH ROUTES
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::put('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');


Route::middleware('auth:sanctum')->group(function () {
    // AUTH ROUTES   
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::post('/resend-email-verification', [AuthController::class, 'resendEmailVerification']);
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');

    // CATEGORY ROUTES
    Route::get('/categories', [CategoryController::class, 'all']);
    Route::get('/categories/{slug}', [CategoryController::class, 'getWithSlug']);
    Route::post('/categories', [CategoryController::class, 'new']);
    Route::put('/categories/{slug}', [CategoryController::class, 'update']);
    Route::delete('/categories/{slug}', [CategoryController::class, 'delete']);

    // COMMENT ROUTES
    Route::post('/comments', [CommentController::class, 'save']);
    Route::delete('/comments/{id}', [CommentController::class, 'delete']);

    // LIKE ROUTES
    Route::post('/likes', [LikeController::class, 'like']);
    Route::delete('/likes/{id}', [LikeController::class, 'unlike']);

    // RIVISTA ROUTES
    Route::get('/rivistas', [RivistaController::class, 'paginate']);
    Route::get('/rivistas/{slug}', [RivistaController::class, 'getWithSlug']);
    Route::post('/rivistas', [RivistaController::class, 'new']);
    Route::put('/rivistas/{id}', [RivistaController::class, 'update']);
    Route::delete('/rivistas/{id}', [RivistaController::class, 'delete']);

    // USER ROUTES
    Route::put('/user', [UserController::class, 'update']);
    Route::get('/user-role', [UserController::class, 'changeRole']); // ADMIN ONLY
    Route::delete('/user', [UserController::class, 'delete']);
});
