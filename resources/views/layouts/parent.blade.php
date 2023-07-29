<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'home')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
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
      <div id="flash-message" class="alert alert-primary u-margin-none u-text-center" role="alert">
        {{ session('flash_message') }}
      </div>
      @endif

      <header id="header" class="l-header js-header">

        <div class="p-header">

          <h1 class="p-header__title">
            <a href="/">Inspiration</a>
          </h1>
            
          <header-component></header-component>

          <nav class="c-nav">
            <ul class="c-nav__list">

              @if(!Auth::check())
                <li class="c-nav__list-item">
                  <a href="/" class="c-nav__list-link">HOME</a>
                </li>
                <li class="c-nav__list-item">
                  <a href="{{ route('ideas.index') }}" class="c-nav__list-link">すべてのアイデア</a>
                </li>
                <li class="c-nav__list-item">
                  <a href="/login" class="c-nav__list-link">ログイン</a>
                </li>
                @if(Route::has('register'))
                  <li class="c-nav__list-item">
                    <a href="/register" class="c-nav__list-link">会員登録</a>
                  </li>
                @endif
              @endif

              @auth
                <li class="c-nav__list-item">
                  <a href="{{ route('mypage') }}" class="c-nav__list-link">マイページ</a>
                </li>

                <li class="c-nav__list-item">
                  <a href="{{ route('ideas.index') }}" class="c-nav__list-link">すべてのアイデア</a>
                </li>

                <li class="c-nav__list-item">
                  <a href="{{ route('new') }}" class="c-nav__list-link">アイデア投稿</a>
                </li>

                <div class="c-nav__submenu">

                  <p class="c-nav__submenu-title js-submenu-trigger">
                    一覧ページ
                    <i class="c-nav__submenu-icon open fa-solid fa-chevron-down js-submenu-open-icon active"></i>
                    <i class="c-nav__submenu-icon close fa-solid fa-chevron-up js-submenu-close-icon"></i>
                  </p>

                  <div class="c-nav__submenu-wrap js-submenu">
                    <li class="c-nav__list-item sub-list">
                      <a href="{{ route('checks', Auth::id() ) }}" class="c-nav__list-link">気になるアイデア</a>
                    </li>
                    <li class="c-nav__list-item sub-list">
                      <a href="{{ route('myposts', Auth::id() ) }}" class="c-nav__list-link">投稿したアイデア</a>
                    </li>
                    <li class="c-nav__list-item sub-list">
                      <a href="{{ route('boughts', Auth::id() ) }}" class="c-nav__list-link">購入したアイデア</a>
                    </li>
                    <li class="c-nav__list-item sub-list">
                      <a href="{{ route('reviews') }}" class="c-nav__list-link">すべてのレビュー</a>
                    </li>
                    <li class="c-nav__list-item sub-list">
                      <a href="{{ route('notifications', Auth::id() ) }}" class="c-nav__list-link">メッセージ一覧</a>
                    </li>

                  </div>
                </div>

                <li class="c-nav__list-item">
                  <a href="{{ route('logout') }}" class="c-nav__list-link">ログアウト</a>
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
      <footer id="footer">
        <footer-component></footer-component>
      </footer>
    @show

<script>
  // フラッシュメッセージを3秒後に消す
  document.addEventListener('DOMContentLoaded', function () {
      var flashMessage = document.getElementById('flash-message');
      if (flashMessage) {
          setTimeout(function () {
              flashMessage.remove();
          }, 1500); // 3秒後にメッセージを削除
      }
  });

  document.addEventListener('DOMContentLoaded', function () {
    // サブメニューのドロップダウン
    function dropdownMenu() {
        document.querySelector('.js-submenu').classList.toggle('is-open');
        document.querySelector('.js-submenu-trigger').classList.toggle('active');
        document.querySelector('.js-submenu-open-icon').classList.toggle('active');
        document.querySelector('.js-submenu-close-icon').classList.toggle('active');
    }

    // クリックイベントを追加
    const submenuTrigger = document.querySelector('.js-submenu-trigger');
    submenuTrigger.addEventListener('click', dropdownMenu);
    });


</script>

<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>


