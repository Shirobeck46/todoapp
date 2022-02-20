<?php
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

use App\http\Controllers\HomeController;
use App\http\Controllers\GoalController;
use App\http\Controllers\TodoController;

Route::get('/', [HomeController::class, 'index']);
// todoアプリにアクセスした際に一番最初に表示れるページの指定

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource("goals", GoalController::class)->middleware('auth');
// GoalのRESTfulなルーティングを実装している。
Route::resource("goals.todos", TodoController::class)->middleware('auth');
// goal.todosのように記述することでネストされたRESTfulなルーティングを実装している
Route::post('/goals/{goal}/todos/{todo}/sort', [TodoController::class, 'sort'])->middleware('auth');
// 作成したTodoを並び替える処理を行うルーティングです。
Route::resource("tags", TagController::class)->middleware('auth');

// ログイン機能で必要なルーティングが設定されている
Auth::routes();
