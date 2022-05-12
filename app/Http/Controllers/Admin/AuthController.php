<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index(){
    return view('admin.index');
  }

  public function login(AdminLoginPostRequest $request)
  {
    $datum = $request->validated();

    // 認証
    if (Auth::guard('admin')->attempt($datum) === false) {
      return back()
            ->withInput() // 入力値の保持
            ->withErrors(['auth' => 'ログインIDかパスワードに誤りがあります。',]) // エラーメッセージの出力
            ;
    }

    $request->session()->regenerate();
    return redirect()->intended('/admin/top');
  }

  public function logout(Request $request){
    Auth::guard('admin')->logout();
    //CSRFトークンの再生成
    $request->session()->regenerateToken();
    //セッションIDの再生成
    $request->session()->regenerate();
    return redirect(route('admin.index'));
  }
}