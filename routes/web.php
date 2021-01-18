<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
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


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('article/{article}/view', [ArticleController::class, 'show'])->name('article.view');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', UserController::class);
    Route::resource('article', ArticleController::class);
    Route::get('user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('article/{article}/delete', [ArticleController::class, 'destroy'])->name('article.delete');
    Route::get('article/{article}/approve', [ArticleController::class, 'approve'])->name('article.approve');
});

