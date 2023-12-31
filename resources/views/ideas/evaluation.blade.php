@extends('layouts.parent')

@section('title', 'レビュー投稿')

@section('main')

    
  <div class="l-form">

    <div class="c-title">アイデア名：{{ $idea->title }}</div>

    <form method="post" action="{{ route('post.review', $idea->id) }}" class="p-form">
      @csrf

        <evaluation-component></evaluation-component>

        <div class="c-form">
          <label for="comment" class="c-form__label">コメント:</label>
          <comment-counter-component :errors="{{ $errors->has('comment') ? 'true' : 'false' }}">
          </comment-counter-component>
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
