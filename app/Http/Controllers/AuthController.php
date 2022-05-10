<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  /**
   * トップページ を表示する
   * 
   * @return \Illuminate\View\View
   */
  public function index()
  {
    return view('index');
  }

  /**
   * ログイン処理
   */
  public function login(LoginPostRequest $request){
    $datum = $request->validated();
    if (Auth::attempt($datum) === false) {
      return back()
        ->withInput() // 入力値の保持
        ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]) // エラーメッセージの出力
        ;
    }
    $request->session()->regenerate();
    return redirect()->intended('/shopping_list/list');
  }
}