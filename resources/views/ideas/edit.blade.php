@extends('layouts.parent')

@section('title', 'idea_edit')

@section('header')

@section('main')
  <h2>アイデア編集画面</h2>

  <div class="l-form">
    <form method="post" action="{{ route('idea.update', $idea->id) }}" class="p-form" enctype="multipart/form-data">
      @include('layouts.form')

      @if($can_edit)
        <div class="p-submit">
          <button type="submit" class="p-submit__button">編集を保存する</button>
        </div>
      @endif
    </form>

    @if($can_edit)
    <form method="post" action="{{ route('idea.delete', $idea->id) }}" class="p-form delete">
      @csrf
      <div class="p-submit">
        <button type="submit" class="p-submit__button submit-delete" onclick="return confirm('このアイデアを削除します。よろしいですか？')">アイデアを削除</button>
      </div>
      @else
        <p class="u-text-right">※すでに購入されたアイデアは編集・削除できません</p>
      @endif
    </form>
  </div>  
@endsection

@section('footer')


