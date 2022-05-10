<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingListController extends Controller
{
  /**
   * タスク一覧ページ を表示する
   * 
   * @return \Illuminate\View\View
   */
  public function list()
  {
    return view('shopping_list.list');
  }
}