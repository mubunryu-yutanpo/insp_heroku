
@extends('layouts.parent')

@section('title', 'メール認証発行')

@section('main')
<div class="u-margin__small-contents">
    <div class="l-form">
        <div class="c-title" style="font-weight: bold;">メールアドレスを確認してください。</div>
        
        <div style="padding: 20px 15px;">

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    メールを送信しました！
                </div>
            @endif

            <p style="margin-bottom: 15px;">メールを送信しました。メール内のリンクをクリックし、本登録をお願いします。</p>
            <p>メールが届いていない場合は、
                <a href="{{ route('verification.resend') }}">ここをクリックしてください。</a>
                再送いたします。
            </p>
        </div>
    </div>

</div>

@endsection

