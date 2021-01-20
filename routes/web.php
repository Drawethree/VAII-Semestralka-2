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
Route::post('/api/checkEmail', [RegisterController::class, 'checkEmailAvailability'])->name('email_available.check');
Route::post('/api/checkUsername', [RegisterController::class, 'checkUsernameAvailability'])->name('username_available.check');
Route::get('/api/blogStats', [HomeController::class, 'getBlogStats'])->name('blog.stats');

Auth::routes();

Route::get('forum/{forum}/article/{article}/view', [ArticleController::class, 'show'])->name('article.view');
Route::get('forum/{forum}/view', [ForumController::class, 'show'])->name('forum.view');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', UserController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('comment', CommentController::class);
    Route::get('admin/articles', [ArticleController::class, 'index'])->name('admin.articles');
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('admin/user/{user}/delete', [UserController::class, 'destroy'])->name('admin.user.delete');
    Route::get('admin/user/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::get('admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::get('admin/article/{article}/delete', [ArticleController::class, 'destroy'])->name('article.delete');
    Route::get('admin/article/{article}/approve', [ArticleController::class, 'approve'])->name('article.approve');
    Route::get('admin/article/{article}/edit', [ArticleController::class, 'edit'])->name('admin.article.edit');
    Route::get('admin/approveAllArticles', [ArticleController::class, 'approveAll'])->name('article.approveAll');
    Route::get('forum/{forum}/createPost', [ForumController::class, 'createArticle'])->name('forum.newpost');
    Route::get('forum/{forum}/article/{article}/comment/{comment}/delete', [CommentController::class, 'delete'])->name('comment.delete');
    Route::get('forum/{forum}/article/{article}/addComment', [CommentController::class, 'create'])->name('comment.create');
    Route::get('forum/{forum}/article/{article}/', [ArticleController::class, 'show'])->name('article.view');

});

