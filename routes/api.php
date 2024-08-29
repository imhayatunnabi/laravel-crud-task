<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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


Route::group(['prefix' => 'user'], function() {
    Route::get('index',[UserController::class, 'index'])->name('index');
    Route::get('store',[UserController::class, 'store'])->name('store');
    Route::get('edit/{slug}',[UserController::class, 'edit'])->name('edit');
    Route::get('update/{slug}',[UserController::class, 'update'])->name('update');
    Route::get('delete/{slug}',[UserController::class, 'delete'])->name('delete');
});
Route::group(['prefix' => 'blog'], function() {
    Route::get('index',[UserController::class, 'index'])->name('index');
    Route::get('store',[UserController::class, 'store'])->name('store');
    Route::get('edit/{slug}',[UserController::class, 'edit'])->name('edit');
    Route::get('update/{slug}',[UserController::class, 'update'])->name('update');
    Route::get('delete/{slug}',[UserController::class, 'delete'])->name('delete');
});

