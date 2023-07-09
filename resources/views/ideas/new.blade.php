@extends('layouts.parent')

@section('title', '新規アイデア投稿')

@section('main')

  <div class="l-form">
    <div class="c-title">アイデア投稿</div>

    <form method="post" action="{{ route('create') }}" class="p-form" enctype="multipart/form-data">

      @include('layouts.form')

      <div class="p-button">
        <button type="submit" class="c-button">登録する</button>
      </div>

    </form>
  </div>
@endsection

@section('footer')


