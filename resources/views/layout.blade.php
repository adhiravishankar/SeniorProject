<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <nav>
            <div class="nav-wrapper">
                <ul class="right hide-on-med-and-down">
                    <li><a href=""><i class="material-icons">search</i></a></li>
                    <li><a href=""><i class="material-icons">view_module</i></a></li>
                    <li><a href="{{ route('acceptancesList') }}"><i class="material-icons">refresh</i></a></li>
                    <li><a href="{{ route('profile') }}"><i class="material-icons">perm_identity</i></a></li>
                </ul>
            </div>
        </nav>
        @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
    </body>
</html>