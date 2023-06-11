@extends('layouts.parent')

@section('title', 'idea_edit')

@section('header')

@section('main')
  <h2>アイデア編集画面</h2>

  <form method="post" action="{{ route('idea.update', $idea->id) }}" class="p-form" enctype="multipart/form-data">
    @include('layouts.form')

    <div class="">
      <button type="submit" class="">登録</button>
      <a href="" class="">削除</a>
    </div>
  </form>
  
@endsection

@section('footer')


<!-- アイデアの投稿・編集ページのスタイルさきにやっちゃう -->