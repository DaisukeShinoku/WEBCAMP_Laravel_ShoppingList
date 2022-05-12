@extends('layout')

@section('title')(購入済み「買うもの」一覧画面)@endsection

@section('contents')
  @if ($errors->any())
    <div>
    @foreach ($errors->all() as $error)
      {{ $error }}<br>
    @endforeach
    </div>
  @endif

  <h1>購入済み「買うもの」一覧</h1>
  <a href="/shopping_list/list">「買うもの」一覧に戻る</a><br>
  <table border="1">
    <tr>
      <th>「買うもの」名</th>
      <th>購入日</th>
    </tr>
    @foreach ($list as $completed_shopping_list)
    <tr>
      <td>{{ $completed_shopping_list->name }}</td>
      <td>{{ $completed_shopping_list->created_at->format('Y-m-d') }}</td>
    </tr>
    @endforeach
  </table>
  <!-- ページネーション -->
  現在 {{ $list->currentPage() }} ページ目<br>
  @if ($list->onFirstPage() === false)
    <a href="/completed_shopping_list/list">最初のページ</a>
  @else
    最初のページ
  @endif
  /
  @if ($list->previousPageUrl() !== null)
    <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
  @else
    前に戻る
  @endif
  /
  @if ($list->nextPageUrl() !== null)
    <a href="{{ $list->nextPageUrl() }}">次に進む</a>
  @else
    次に進む
  @endif
  <br>
  <!-- ページネーション -->
  <hr>
  <menu label="リンク">
    <a href="/logout">ログアウト</a><br>
  </menu>
@endsection