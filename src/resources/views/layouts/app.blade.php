<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate - 商品一覧</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/dreampulse/computer-modern-web-font@master/fonts.css">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="{{ route('products.index') }}" class="site-title">mogitate</a>
        </div>
    </header>
    
    <div class="container">
        <main class="main-content">
            @yield('content')
        </main>
    </div>
   
</body>
</html>