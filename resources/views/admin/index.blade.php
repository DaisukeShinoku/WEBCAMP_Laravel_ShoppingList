@extends('layout')

@section('title')@endsection

@section('contents')
@if($errors->any())
  <div>
    @foreach($errors->all() as $error)
    {{ $error }}<br>
    @endforeach
  </div>
@endif
  <h1>管理画面　ログイン</h1>
  <form action="/admin/login" method="post">
    @csrf
    ログインID：<input name="login_id" value="{{ old('login_id') }}"><br>
    パスワード：<input  name="password" type="password"><br>
    <button>ログインする</button><br>
  </form>
@endsection