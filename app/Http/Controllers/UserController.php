<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;

class Userontroller extends Controller
{
  /**
   * 新規登録画面を表示する
   * 
   * @return \Illuminate\View\View
   */
  public function index(){
    return view('user.index');
  }
}