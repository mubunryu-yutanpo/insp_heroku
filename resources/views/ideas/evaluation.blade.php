@extends('layouts.parent')

@section('title', 'レビュー投稿')

@section('header')

@section('main')
  <h2>レビュー投稿ページ</h2>
  
  <div class="">
    <p class="">{{ $idea->title }}</p>
  </div>  
  
  <form method="post" action="" class="p-form">
    @csrf

      <evaluation-component></evaluation-component>

        <div class="c-form__input">
        <label for="comment" class="c-form__input__label">コメント:</label>
        <input type="comment" name="comment" id="comment" class="c-form__input__field @error('comment') valid-error @enderror" autocomplete="comment" value="{{ old('comment') }}">
        @error('comment')
            <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>

        <div class="p-submit">
        <button type="submit" class="p-submit__button">登録する</button>
        </div>

    </form>
@endsection

@section('footer')


<!-- レビュー投稿処理・ルートまだ -->