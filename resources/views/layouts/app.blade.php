<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="@yield('meta_description', '')">
    <title>@yield('title', 'AppealDB')</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    @stack('css')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    <nav class="nav has-shadow">
        <div class="nav-left">
            <a class="nav-item is-brand" href="/">
                AppealDB
            </a>
        </div>

        <div class="nav-center">
            <a class="nav-item" href="https://github.com/defiant/appealDB">
                <span class="icon">
                    <i class="fa fa-github"></i>
                </span>
            </a>
            <a class="nav-item" href="#">
                <span class="icon">
                    <i class="fa fa-twitter"></i>
                </span>
            </a>
        </div>

        {{--<span class="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
        </span>--}}

        <div class="nav-right nav-menu">
            <a class="nav-item" href="/">
                Home
            </a>

            <a class="nav-item" href="/create">
                Create New
            </a>

            <a class="nav-item" href="/documentation">
                Docs
            </a>
        </div>
    </nav>

    {{--<nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>--}}

    @yield('content')

    <footer class="footer">
        <div class="container">
            <hr>
            <div class="content has-text-centered">
                <p>
                    <strong>AppealDB</strong> by <a href="http://sinantaga.com">Sinan Taga</a>. The source code is licensed
                    <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
                    is licensed <a href="http://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a>.
                </p>
                <p>
                    <a class="icon" href="https://github.com/defiant/appealDB">
                        <i class="fa fa-github"></i>
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('js')

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-2862188-15', 'auto');
      ga('send', 'pageview');

    </script>
</body>
</html>
