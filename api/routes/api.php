<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RivistaController;
use App\Http\Controllers\UserController;
use App\Http\Response;

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
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::put('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');


Route::middleware('auth:sanctum')->group(function () {
    // AUTH ROUTES   
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::post('/resend-email-verification', [AuthController::class, 'resendEmailVerification']);
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification');

    // RIVISTA ROUTES
    Route::post('/rivistas', [RivistaController::class, 'new']);
    Route::put('/rivistas/{id}', [RivistaController::class, 'update']);
    Route::delete('/rivistas/{id}', [RivistaController::class, 'delete']);

    // COMMENT ROUTES
    Route::post('/connected-comments', [CommentController::class, 'save']);
    Route::delete('/comments/{id}', [CommentController::class, 'delete']);

    // LIKE ROUTES
    Route::post('/likes', [LikeController::class, 'like']);
    Route::delete('/likes', [LikeController::class, 'unlike']);

    // USER ROUTES
    Route::get('/user', [UserController::class, 'get']);
    Route::put('/user', [UserController::class, 'update']);
    Route::delete('/user', [UserController::class, 'delete']);

    // MEDIA ROUTES
    Route::post('/media/rivistas', [MediaController::class, 'uploadRivista']);
    Route::post('/media/profile', [MediaController::class, 'uploadProfile']);
    Route::delete('/media/rivistas/{id}', [MediaController::class, 'deleteRivista']);
    Route::delete('/media/profile', [MediaController::class, 'deleteProfile']);
    
    Route::middleware('admin')->group(function () {
        // CATEGORY ROUTES
        Route::get('/admin/categories/{slug}', [CategoryController::class, 'get']); // ADMIN ONLY
        Route::post('/categories', [CategoryController::class, 'new']); // ADMIN ONLY
        Route::put('/categories/{slug}', [CategoryController::class, 'update']); // ADMIN ONLY
        Route::delete('/categories/{slug}', [CategoryController::class, 'delete']); // ADMIN ONLY
        
        Route::put('/user-role', [UserController::class, 'changeRole']); // ADMIN ONLY

        // MEDIA ROUTES
        Route::post('/media/categories', [MediaController::class, 'uploadCategory']);
        Route::delete('/media/categories/{slug}', [MediaController::class, 'deleteCategory']);
    });
});

// COMMENT ROUTE
Route::post('/guest-comments', [CommentController::class, 'save']);

Route::any('/test', function () {
    return Response::Ok("Test Works!");
});

// CATEGORY ROUTES
Route::get('/categories', [CategoryController::class, 'all']);
Route::get('/categories/{slug}', [CategoryController::class, 'getWithSlug']);

// RIVISTA ROUTES
Route::get('/rivistas', [RivistaController::class, 'paginate']);
Route::get('/rivistas/{slug}', [RivistaController::class, 'getWithSlug']);

// USER ROUTES
Route::get('/users', [UserController::class, 'all']);
Route::get('/users/{slug}', [UserController::class, 'getWithSlug']);

// VIEWS ROUTES
Route::get('/views/rivistas', [RivistaController::class, 'views']);
Route::get('/views/categories', [CategoryController::class, 'views']);
Route::get('/views/users', [UserController::class, 'views']);

// LIKES ROUTES
Route::get('/likes/rivistas', [RivistaController::class, 'likes']);
Route::get('/likes/categories', [CategoryController::class, 'likes']);
Route::get('/likes/users', [UserController::class, 'likes']);
