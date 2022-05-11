<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShoppingList as ShoppingListModel;
use App\Http\Requests\ShoppingListRegisterPostRequest;
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
    $per_page = 20;

    $list = ShoppingListModel::where('user_id', Auth::id())->paginate($per_page);
    return view('shopping_list.list', ['list' => $list]);
  }

  public function register(ShoppingListRegisterPostRequest $request)
  {
    // validate済みのデータの取得
    $datum = $request->validated();
    $datum['user_id'] = Auth::id();
    try {
      $r = ShoppingListModel::create($datum);
    } catch(\Throwable $e) {
      echo $e->getMessage();
      exit;
    }

    $request->session()->flash('front.shopping_list_register_success', true);
    return redirect('/shopping_list/list');
  }
}