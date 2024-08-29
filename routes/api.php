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
/**
 * Define routes for admin operations including user and blog management.
 * Uses authentication middleware 'auth:sanctum' for secure access.
 * Admin can perform actions like logout, view, create, edit, update, and delete users and blogs.
 */
Route::prefix('admin')->name('api.')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [UserController::class, 'edit'])->name('edit');
        Route::put('update/{slug}', [UserController::class, 'update'])->name('update');
        Route::get('delete/{slug}', [UserController::class, 'delete'])->name('delete');
    });
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('index', [BlogController::class, 'index'])->name('index');
        Route::post('store', [BlogController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [BlogController::class, 'edit'])->name('edit');
        Route::put('update/{slug}', [BlogController::class, 'update'])->name('update');
        Route::get('delete/{slug}', [BlogController::class, 'delete'])->name('delete');
    });
});
