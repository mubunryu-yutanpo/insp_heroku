<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'home')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @section('header')
      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
      <div class="alert alert-primary text-center" role="alert">
        {{ session('flash_message') }}
      </div>
      @endif

      <header id="header" class="l-header">

        <div class="p-header__container">

          <div class="c-header-logo">
            <img src="/images/logo.png" alt="" class="c-header-logo__image">
          </div>

          <div class="c-header__contents">
            
            <header-component></header-component>

            @if(!Auth::check())
              <a href="{{ route('login') }}" class="c-header__login-link">ログイン</a>
              @if(Route::has('register'))
                <a href="{{ route('register') }}" class="c-header__register-link">会員登録</a>
              @endif
            @endif
          </div>


          <nav class="c-header__nav">
            <ul class="c-header__nav__list">
              <li class="c-header__nav__item">
                <a href="/" class="c-header__nav__link">HOME</a>
              </li>
              <li class="c-header__nav__item">
                <a href="{{ route('ideas.index') }}" class="c-header__nav__link">アイデア一覧</a>
              </li>
              @auth
                <li class="c-header__nav__item">
                  <a href="{{ route('mypage') }}" class="c-header__nav__link">マイページ</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('new') }}" class="c-header__nav__link">アイデア投稿</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('checks', Auth::id() ) }}" class="c-header__nav__link">気になるリスト</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('myposts', Auth::id() ) }}" class="c-header__nav__link">投稿したアイデア一覧</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('boughts', Auth::id() ) }}" class="c-header__nav__link">購入したアイデア一覧</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('prof.edit', Auth::id()) }}" class="c-header__nav__link">プロフィール編集</a>
                </li>
                <li class="c-header__nav__item">
                  <a href="{{ route('logout') }}" class="c-header__nav__link">ログアウト</a>
                </li>
              @endauth
            </ul>
          </nav>
        </div>
      </header>
    @show
    
    
    
    <main id="main" class="l-main">
        @yield('main')
    </main>
    

    @section('footer')
      <div id="footer">
        <footer-component></footer-component>
      </div>
    @show

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


