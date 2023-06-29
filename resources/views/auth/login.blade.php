@extends('layouts.parent')

@section('title', 'ログインフォーム')

@section('main')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->


<div class="">
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
                    ログインを保持するログインする
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
