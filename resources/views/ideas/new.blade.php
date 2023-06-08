@extends('layouts.parent')

@section('title', '新規アイデア投稿')

@section('header')

@section('main')
  <h2>アイデア新規投稿ページ</h2>
  <form method="post" action="{{ route('create') }}" class="p-form" enctype="multipart/form-data">

    @include('form')

    <div class="p-submit">
      <button type="submit" class="p-submit__button">登録する</button>
    </div>

  </form>

@endsection

@section('footer')