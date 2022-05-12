<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User as UserModel;

class UserController extends Controller
{
  public function list(){
    $lists = UserModel::withCount('completed_shopping_lists')->get();
    return view('admin.user.list',['lists'=>$lists]);
  }
}