@extends('layout')
@section('contents')
  @if($errors->any())
  <div>
    @foreach ($errors ->all() as $error)
    {{ $error }}<br>
    @endforeach
  </div>
  @endif
  <h1>ユーザー登録</h1>
  <form action="/user/register" method="post">
    @csrf
    名前：<input name="name" value="{{old('name')}}"><br>
    email：<input name="email" value="{{old('email')}}"><br>
    パスワード：<input  name="password" type="password"><br>
    パスワード(再度)：<input  name="password_confirmation" type="password"><br>
    <button>登録する</button>
  </form>
  <a href="/">ログイン画面へ戻る</a><br>
@endsection