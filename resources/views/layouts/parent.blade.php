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
            <header-component></header-component>

            @if(Route::has('login'))
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
                    <a href="{{ route('reviews') }}" class="c-header__nav__link">レビュー一覧</a>
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
                @else
                  <li class="c-header__nav__item">
                    <a href="{{ route('login') }}" class="c-header__nav__link">ログイン</a>
                  </li>
                  @if(Route::has('register'))
                    <li class="c-header__nav__item">
                      <a href="{{ route('register') }}" class="c-header__nav__link">登録</a>
                    </li>
                  @endif
                @endauth
              </ul>
            </nav>
            @endif
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


