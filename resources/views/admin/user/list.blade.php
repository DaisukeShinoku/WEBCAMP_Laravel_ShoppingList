@extends('admin.layout')

@section('title')@endsection

@section('contents')
  <h1>ユーザー一覧</h1>
  <table border="1">
    <tr>
      <th>ユーザーID</th>
      <th>ユーザー名</th>
      <th>購入した「買うもの」数</th>
    </tr>
    @foreach($lists as $user)
    <tr>
      <td>{{ $user->id }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->completed_shopping_lists_count}}</td>
    </tr>
    @endforeach
  </table>
@endsection