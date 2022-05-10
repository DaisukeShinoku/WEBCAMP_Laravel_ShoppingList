<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPostRequest;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
  /**
   * 新規登録画面を表示する
   * 
   * @return \Illuminate\View\View
   */
  public function index(){
    return view('user.index');
  }

  /**
   * 登録処理
   * 
   */
  public function register(UserRegisterPostRequest $request)
  {
    $datum = $request->validated();
    $datum['password'] = Hash::make($datum['password']);
    try{
      $r= UserModel::create($datum);
      $request->session()->flash('front.user_register_success',true);
    }catch(\Throwable $e){
      $request->session()->flash('front.user_register_failure', true);
    }
    return redirect('/');
  }
}