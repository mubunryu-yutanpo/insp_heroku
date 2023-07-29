@extends('layouts.parent')

@section('title', 'パスワード再発行')

@section('main')

<div class="l-form">
    <form action="{{ route('password.update') }}" method="post" class="p-form">
        @csrf

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


        <div class="p-button">
          <button type="submit" class="c-button">パスワードを変更して登録</button>
        </div>

    </form>

</div>

@endsection
