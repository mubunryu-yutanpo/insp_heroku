@extends('layouts.parent')

@section('title', 'レビュー投稿')

@section('main')
  <h2>レビュー投稿ページ</h2>
    
  <div class="l-form">
    <div class="c-title">アイデア名：{{ $idea->title }}</div>

    <form method="post" action="{{ route('post.review', $idea->id) }}" class="p-form">
      @csrf

        <evaluation-component></evaluation-component>

        <div class="c-form">
          <label for="comment" class="c-form__label">コメント:</label>
          <textarea name="comment" id="comment" cols="30" rows="10" class="c-form__input input-textarea @error('comment') valid-error @enderror">
              {{ old('comment') }}
          </textarea>
          @error('comment')
              <span class="c-form__error" role="alert">
              <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="p-button">
        <button type="submit" class="c-button">登録する</button>
        </div>

    </form>
  </div>
@endsection

@section('footer')
