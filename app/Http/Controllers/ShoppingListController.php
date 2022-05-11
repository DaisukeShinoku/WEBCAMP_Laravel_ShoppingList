<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShoppingList as ShoppingListModel;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;
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

    $list = ShoppingListModel::where('user_id', Auth::id())->orderBy('name')->paginate($per_page);
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
   * 買い物の完了
   */
  public function complete(Request $request, $shopping_list_id)
  {
    try {
      DB::beginTransaction();
      $shopping_list = $this->getShoppingListModel($shopping_list_id);
      if ($shopping_list === null) {
        throw new \Exception('');
      }
      $shopping_list->delete();

      $dask_datum = $shopping_list->toArray();
      unset($dask_datum['created_at']);
      unset($dask_datum['updated_at']);
      $r = CompletedShoppingListModel::create($dask_datum);
      if ($r === null) {
        throw new \Exception('');
      }
      DB::commit();
      $request->session()->flash('front.shopping_list_completed_success', true);
    } catch(\Throwable $e) {
      DB::rollBack();
      $request->session()->flash('front.shopping_list_completed_failure', true);
    }
    return redirect('/shopping_list/list');
  }

  /**
   * 「単一の買い物リスト」Modelの取得
   */
  protected function getShoppingListModel($shopping_list_id)
  {
    $shopping_list = ShoppingListModel::find($shopping_list_id);
    if ($shopping_list === null) {
      return null;
    }
    // 本人以外の買い物リストならNGとする
    if ($shopping_list->user_id !== Auth::id()) {
      return null;
    }
    return $shopping_list;
  }
}