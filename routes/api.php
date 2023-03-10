<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\UserAuthController;

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

Route::controller(UserAuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::get('/login', 'login');
});

Route::middleware('auth:api')->group(function() {
    // Route::apiResource('/users', UsersController::class);
    Route::controller(UsersController::class)->group(function () {
        Route::get('/users/{id}', 'show');
        Route::get('/users', 'index');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });

    // Route::apiResource('/quiz', QuizController::class);
    Route::controller(QuizController::class)->group(function () {
        Route::get('/quiz/{id}', 'show');
        Route::get('/quiz', 'index');
        Route::post('/quiz', 'create');
        Route::put('/quiz/{id}', 'update');
        Route::delete('/quiz/{id}', 'destroy');
    });
});


