<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Auth\AuthController;

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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'user'], function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [UserController::class, 'edit'])->name('edit');
        Route::put('update/{slug}', [UserController::class, 'update'])->name('update');
        Route::get('delete/{slug}', [UserController::class, 'delete'])->name('delete');
    });
    Route::group(['prefix' => 'blog'], function () {
        Route::get('index', [BlogController::class, 'index'])->name('index');
        Route::post('store', [BlogController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [BlogController::class, 'edit'])->name('edit');
        Route::put('update/{slug}', [BlogController::class, 'update'])->name('update');
        Route::get('delete/{slug}', [BlogController::class, 'delete'])->name('delete');
    });
});
