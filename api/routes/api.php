<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

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
Route::put('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    // AUTH ROUTES   
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::post('/resend-email-verification', [AuthController::class, 'resendEmailVerification']);

    // CATEGORY ROUTES
    Route::get('/categories', [CategoryController::class, 'all']);
    Route::get('/categories/{slug}', [CategoryController::class, 'getWithSlug']);
    Route::post('/categories', [CategoryController::class, 'new']);
    Route::put('/categories/{slug}', [CategoryController::class, 'update']);
    Route::delete('/categories/{slug}', [CategoryController::class, 'delete']);
});
