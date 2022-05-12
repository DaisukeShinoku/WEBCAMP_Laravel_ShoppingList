<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShoppingList as CompletedShoppingList;

class CompletedShoppingListController extends Controller
{
  public function list()
  {
    // 1page辺りの表示アイテム数を設定
    $per_page = 20;

    // 一覧の取得
    $list = CompletedShoppingList::where('user_id', Auth::id())
            ->orderBy('name')
            ->orderBy('created_at')
            ->paginate($per_page);

    return view('completed_shopping_list.list', ['list' => $list]);
  }
}