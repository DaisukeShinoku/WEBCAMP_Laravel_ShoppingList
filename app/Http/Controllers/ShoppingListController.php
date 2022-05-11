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
   * 買い物リスト一覧ページを表示する
   * 
   * @return \Illuminate\View\View
   */
  public function list()
  {
    $per_page = 20;

    $list = ShoppingListModel::where('user_id', Auth::id())->paginate($per_page);
    return view('shopping_list.list', ['list' => $list]);
  }

  /**
   * 買い物リストを追加する
   */
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

  /**
   * 削除処理
   */
  public function delete(Request $request, $shopping_list_id)
  {
    $shopping_list = $this->getShoppingListModel($shopping_list_id);

    if ($shopping_list !== null) {
      $shopping_list->delete();
      $request->session()->flash('front.shopping_list_delete_success', true);
    }

    return redirect('/shopping_list/list');
  }

  /**
   * 「単一のタスク」Modelの取得
   */
  protected function getShoppingListModel($shopping_list_id)
  {
    $shopping_list = ShoppingListModel::find($shopping_list_id);
    if ($shopping_list === null) {
      return null;
    }
    // 本人以外のタスクならNGとする
    if ($shopping_list->user_id !== Auth::id()) {
      return null;
    }
    return $shopping_list;
  }
}