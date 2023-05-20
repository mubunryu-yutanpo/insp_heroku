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
      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
      <div class="alert alert-primary text-center" role="alert">
        {{ session('flash_message') }}
      </div>
      @endif

      <header id="header" class="l-header">

        <div class="p-header__container">
            <header-component></header-component>
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