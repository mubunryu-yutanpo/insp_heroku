@extends('layouts.parent')

@section('title', 'パスワードリセットリンク発行')

@section('main')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
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
            <button type="submit" class="p-submit__button">再発行する</button>
            </div>

        </form>

    </div>

</div>

@endsection
