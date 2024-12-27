<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CastController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\GenreController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CastMovieController;

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

Route::prefix('v1')->group(function () {
    Route::apiResource('cast', CastController::class);
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('movie', MovieController::class);
    Route::apiResource('cast-movie', CastMovieController::class);
    // Route::apiResource('review', [ReviewController::class, 'storeupdate'])->middleware(['auth:api', 'isadmin']);
    Route::apiResource('role', RoleController::class)->middleware(['auth:api', 'isadmin']);
    // Route::apiResource('me', AuthController::class)->middleware('auth:api');
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        // Route::post('/update', [AuthController::class, 'update']);
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('/verifikasi-akun', [AuthController::class, 'verifikasi'])->middleware('auth:api');
        Route::post('/generate-otp-code', [AuthController::class, 'generateOtp'])->middleware('auth:api');
        })->middleware('api');
        // Route::post('/login', [AuthController::class, 'login']);

        // profile
        Route::post('/profile', [ProfileController::class, 'storeupdate'])->middleware(['auth:api','verifiedAccount']);

        //review
        Route::post('/review', [ReviewController::class, 'storeupdate'])->middleware(['auth:api','verifiedAccount']);
    });

    