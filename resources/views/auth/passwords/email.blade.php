@extends('layouts.parent')

@section('title', 'パスワードリセットリンク発行')

@section('main')
<div class="u-margin__small-contents">
    <div class="l-form">
        <div class="c-title">パスワードリセット</div>
  
        <form action="{{ route('password.email') }}" method="post" class="p-form">
            @csrf

            <div class="c-form">
                <p class="c-form__text">以下のメールアドレスにパスワード再発行のためのリンクをお送りします。</p>
            </div>

            <div class="c-form">
                <div class="c-form__wrap wrap-email">
                <label for="email" class="c-form__label">メールアドレス:</label>
                <input id="email" type="email" class="c-form__input @error('email') valid-error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="c-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>

            <div class="p-submit">
            <button type="submit" class="p-submit__button">リンクを受け取る</button>
            </div>

        </form>

    </div>

</div>

@endsection
