<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/article/{article}', [ArticleController::class, 'show'])->name('articles.article');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


//articles/create kan niet onder /article/{article}, de router neemt aan dat create dan de waarde is van {article}.
Route::group(['middleware' => ['auth', 'web']], function() {
    // ik heb geen @csrf nodig, ookal heb ik hier web als middleware.......... wat?
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles/create/new', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/article/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/article/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/article/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create/new', [CategoryController::class, 'store'])->name('categories.store');

    // all roads lead to article/1
    // de 1 was user_id.
    Route::post('/articles/article/{article}', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/login/logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::get('/account', [AccountController::class, 'show'])->name('account.account');

    Route::get('/articles/article/{article}/subscribe', [ArticleController::class, 'subscribe'])->name('article.subscribe');
    Route::put('/account/purchase/{article}/subscription', [AccountController::class, 'purchase'])->name('account.pay');

    /*
    subscribe   ArticleController?
    confirmsub  ArticleController?
    mysubs      AccountController (en boven My Articles in de HTML) hoeft geen eigen functie. just get and show subs.
    */

});

Route::view('/login', 'account/login')->name('login');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->middleware('web')->name('account.authenticate');

Route::redirect('/', '/articles')->name('index');
