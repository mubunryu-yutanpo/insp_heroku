@extends('layouts.parent')

@section('title', 'リンク有効期限切れ')

@section('main')
<div class="u-margin__small-contents">
    <div class="l-form">
        <div class="c-title">パスワードリセット</div>
  
        <form action="{{ route('password.email') }}" method="post" class="p-form">
            @csrf

            <div class="c-form">
                <p class="c-form__text">リンクの有効期限が切れています。お手数ですがもう一度メールアドレスを入力し、リンクから再設定してください。</p>
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

            <div class="p-button">
            <button type="submit" class="c-button">再度リンクを受け取る</button>
            </div>

        </form>

    </div>

</div>

@endsection
