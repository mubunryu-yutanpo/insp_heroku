@extends('layouts.parent')

@section('title', 'ユーザー登録')

@section('main')
<div class="u-margin__small-contents">
    <div class="l-form">
        <div class="c-title">新規ユーザー登録</div>

        <form action="{{ route('register') }}" method="post" class="p-form">
            @csrf

            <div class="c-form">
                <div class="c-form__wrap wrap-name">
                <label for="name" class="c-form__label">名前:</label>
                <input id="name" type="text" class="c-form__input @error('name') valid-error @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="c-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
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

            <div class="c-form">
                <div class="c-form__wrap wrap-password">
                <label for="password" class="c-form__label">パスワード:</label>
                <input id="password" type="password" class="c-form__input @error('password') valid-error @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="c-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>

            <div class="c-form">
                <div class="c-form__wrap wrap-password">
                <label for="password-confirm" class="c-form__label">パスワード(再入力):</label>
                <input id="password-confirm" type="password" class="c-form__input @error('password-confirm') valid-error @enderror" name="password_confirmation" required autocomplete="new-password">
                @error('password-confirm')
                <span class="c-form__error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
            </div>


            <div class="p-submit">
              <button type="submit" class="p-submit__button">新規登録する</button>
            </div>

        </form>
    </div>
</div>

@endsection
