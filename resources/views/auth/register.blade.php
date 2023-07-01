@extends('layouts.parent')

@section('title', 'ユーザー登録')

@section('main')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->


<div class="l-form">
    <div class="c-title">新規ユーザー登録</div>

    <form action="{{ route('register') }}" method="post" class="p-form">
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

          </div>
        </div>

        <div class="p-submit">
          <button type="submit" class="p-submit__button">新規登録する</button>
        </div>

    </form>

</div>

@endsection
