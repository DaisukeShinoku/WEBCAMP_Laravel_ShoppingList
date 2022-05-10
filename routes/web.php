<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShoppingListController;

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

// ログイン
Route::get('/',[AuthController::class,'index'])->name('login');
Route::post('/login',[AuthController::class,'login']);
// 会員登録
Route::prefix('/user')->group(function () {
  Route::get('/register', [UserController::class, 'index'])->name('front.user.register');
  Route::post('/register', [UserController::class, 'register'])->name('front.user.register.post');
});
// 認可処理
Route::middleware(['auth'])->group(function () {
  // 買い物リスト
  Route::prefix('/shopping_list')->group(function(){
    Route::get('/list',[ShoppingListController::class,'list']);
  });
  // ログアウト
  Route::get('/logout', [AuthController::class, 'logout']);
});