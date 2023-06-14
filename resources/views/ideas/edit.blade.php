@extends('layouts.parent')

@section('title', 'idea_edit')

@section('header')

@section('main')
  <h2>アイデア編集画面</h2>

  <form method="post" action="{{ route('idea.update', $idea->id) }}" class="p-form" enctype="multipart/form-data">
    @include('layouts.form')

    @if($can_edit)
      <div class="p-submit">
        <button type="submit" class="p-submit__button">登録</button>
        <a href="" class="p-submit__button submit-delete" onclick="return confirm('このアイデアを削除します。よろしいですか？')">削除</a>
      </div>
    @else
      <p class="u_text-right">※すでに購入されたアイデアは編集・削除できません</p>
    @endif

  </form>
  
@endsection

@section('footer')


<!-- アイデア詳細ページのスタイル -->