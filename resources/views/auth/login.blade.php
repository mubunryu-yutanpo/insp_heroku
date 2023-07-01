@extends('layouts.parent')

@section('title', 'ログインフォーム')

@section('main')

<div class="l-form">
    <div class="c-title">ログイン</div>

    <form action="{{ route('login') }}" method="post" class="p-form">
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
          <div class="c-form__container">
            <div class="c-form__wrap wrap-remember">
                <input class="c-form__input input-remember" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="c-form__label label-remember" for="remember">
                    ログインを保持する
                </label>
            </div>
            @if (Route::has('password.request'))
                <div class="c-form__wrap wrap-forgot">
                    <a class="" href="{{ route('password.request') }}">
                        パスワードをお忘れの方はこちら
                    </a>
                </div>
            @endif

          </div>
        </div>

        <div class="p-submit">
          <button type="submit" class="p-submit__button">ログインする</button>
        </div>

    </form>

</div>
@endsection
