<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'home')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    @section('header')
      <header id="header" class="l-header">
        <div class="c-header-logo">
          <img src="images/logo.png" alt="" class="c-header-logo__image">
        </div>

        <div class="p-header__container">
            
            <header-component></header-component>

            <nav class="c-header__nav">
            @if(Route::has('login'))
              <ul class="c-header__nav__list">
                <li class="c-header__nav__item">
                    <a href="/" class="c-header__nav__link">HOME</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">アイデア一覧</a>
                </li>
                @auth
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">マイページ</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">アイデアを投稿</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">気になるリスト</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">購入したアイデア</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">ログアウト</a>
                </li>
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">プロフィール編集</a>
                </li>
                @else
                <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">ログイン</a>
                </li>
                @if(Route::has('register'))
                    <li class="c-header__nav__item">
                    <a href="#" class="c-header__nav__link">登録</a>
                    </li>
                @endif
                @endauth
              </ul>
            @endif
            </nav>

        </div>
      </header>
    @show
    
    <!-- フラッシュメッセージ -->
     @if (session('flash_message'))
      <div class="alert alert-primary text-center" role="alert">
        {{ session('flash_message') }}
      </div>
    @endif
    
    
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