<?php

use App\Http\Controllers\BuildReleaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadLibaryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('build-release', BuildReleaseController::class);
    Route::get('/upload', [UploadLibaryController::class, 'index'])->name('upload');
    Route::post('/upload', [UploadLibaryController::class, 'upload'])->name('uploadFile');
    Route::get('/delete-lib/{id}', [UploadLibaryController::class, 'destroy'])->name('delete.libary');
});
