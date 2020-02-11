<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Warikan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="my-navbar">
            <a href="{{ route('bill.index') }}" class="my-navbar-brand">Warikan</a>
            <div class="my-navbar-control">
                @if(Auth::check())
                    <span class="my-navbar-item">ようこそ、{{ Auth::user()->name }}</span>
                    |
                    <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                    <form  action="{{ route('logout') }}" id="logout-form" method="post" style="display:none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="my-navbar-item">ログイン</a>
                    <a href="{{ route('register') }}" class="my-navbar-item">会員登録</a>
                @endif
            </div>
        </nav>
    </header>
    @yield('content')

@if(Auth::check())
    <script>
        document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
@endif
</body>
</html>