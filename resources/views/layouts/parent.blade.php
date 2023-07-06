<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'home')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@5.0.2/css/swiper.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@5.0.2/js/swiper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-awesome-swiper@3.1.3/dist/vue-awesome-swiper.min.js"></script>
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

        <div class="p-header">

          <div class="p-header__logo">
            <a href="/">
            <img src="/images/logo.png" alt="" class="p-header__logo-image">
            </a>
          </div>

          <div class="p-header__contents">
            
            @if(!Auth::check())
              <a href="{{ route('login') }}" class="p-header__contents-login">ログイン</a>
              @if(Route::has('register'))
                <a href="{{ route('register') }}" class="p-header__contents-register">会員登録</a>
              @endif
            @endif

            @if(Route::currentRouteName() == 'mypage')
              <a href="{{ route('prof.edit', Auth::id() ) }}" class="p-header__contents-profile">プロフィール編集</a>
            @endif

            <header-component></header-component>

          </div>
        </div>


          <nav class="c-nav">
            <ul class="c-nav__list">
              <li class="c-nav__item">
                <a href="/" class="c-nav__link">HOME</a>
              </li>
              <li class="c-nav__item">
                <a href="{{ route('ideas.index') }}" class="c-nav__link">アイデア一覧</a>
              </li>
              @auth
                <li class="c-nav__item">
                  <a href="{{ route('mypage') }}" class="c-nav__link">マイページ</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('new') }}" class="c-nav__link">アイデア投稿</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('checks', Auth::id() ) }}" class="c-nav__link">気になるリスト</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('myposts', Auth::id() ) }}" class="c-nav__link">投稿したアイデア一覧</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('boughts', Auth::id() ) }}" class="c-nav__link">購入したアイデア一覧</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('reviews') }}" class="c-nav__link">レビュー一覧</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('notifications', Auth::id() ) }}" class="c-nav__link">通知一覧</a>
                </li>
                <li class="c-nav__item">
                  <a href="{{ route('logout') }}" class="c-nav__link">ログアウト</a>
                </li>
              @endauth
            </ul>
          </nav>
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


