@extends('layouts.parent')

@section('title', 'アイデア編集')

@section('main')

  <div class="l-form">
    <div class="c-title">アイデア編集</div>

    <form method="post" action="{{ route('idea.update', $idea->id) }}" class="p-form" enctype="multipart/form-data">
      @include('layouts.form')

      @if($can_edit)
        <div class="p-button">
          <button type="submit" class="c-button">編集を保存する</button>
        </div>
      @endif
    </form>

    @if($can_edit)
    <form method="post" action="{{ route('idea.delete', $idea->id) }}" class="p-form delete">
      @csrf
      <div class="p-button">
        <button type="submit" class="c-button button-delete" onclick="return confirm('このアイデアを削除します。よろしいですか？')">アイデアを削除</button>
      </div>
      @else
        <p class="u-text-right">※すでに購入されたアイデアは編集・削除できません</p>
      @endif
    </form>
  </div>  
@endsection

@section('footer')


