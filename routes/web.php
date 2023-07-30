<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MissingQuestionController;
use App\Http\Controllers\UserController;

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

require __DIR__.'/auth.php';

Route::get('/',  [HomeController::class, 'about'])->name('home');
Route::get('/news',  [HomeController::class, 'news'])->name('news');
Route::resource('conversations', ConversationController::class)->only('index', 'show');
Route::resource('turns', TurnController::class)->only('index', 'store');

Route::middleware(['auth', 'role'])->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('categories/regenerate',  [CategoryController::class, 'regenerate'])->name('categories.regenerate');
    Route::get('categories/download',  [CategoryController::class, 'download'])->name('categories.download');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('missing-questions', MissingQuestionController::class)->except('store', 'create');
});