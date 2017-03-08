<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
        @yield('styles')
    </head>
    <body>
        <nav>
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{ route('profile') }}"><i class="material-icons">perm_identity</i></a></li>
                </ul>
            </div>
        </nav>
        @yield('content')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
        @yield('scripts')
    </body>
</html>