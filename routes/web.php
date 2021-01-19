<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/checkEmail', [RegisterController::class, 'checkEmailAvailability'])->name('email_available.check');
Route::post('/checkUsername', [RegisterController::class, 'checkUsernameAvailability'])->name('username_available.check');
Route::get('/blogStats', [HomeController::class, 'getBlogStats'])->name('blog.stats');
Auth::routes();

Route::get('article/{article}/view', [ArticleController::class, 'show'])->name('article.view');
Route::get('forum/{forum}/view', [ForumController::class, 'show'])->name('forum.view');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', UserController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('comment', CommentController::class);
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('article/{article}/delete', [ArticleController::class, 'destroy'])->name('article.delete');
    Route::get('article/{article}/approve', [ArticleController::class, 'approve'])->name('article.approve');
    Route::get('/approveAllParticles', [ArticleController::class, 'approveAll'])->name('article.approveAll');

});

