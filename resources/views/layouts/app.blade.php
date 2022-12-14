<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>

</head>

<body class="antialiased">
    <?php
    $settings = getSettings();
    ?>
    <div class="container contain">
        <h4 class="header mb-1">Welcome to AU-FPL</h4>
        @if ( Session::has('error'))
        <h5 style="color:red; text-align:center">{{ session::get('error') }}</h5>
        @endif
        @if ( Session::has('success'))
        <h5 style="color:green; text-align:center">{{ session::get('success') }}</h5>
        @endif
        <div class="menu mt-4">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route('points')}}">Points</a>
                </li>
                <li class="nav-item">
                    @if($settings['squad_selection_open'])
                    <a class="nav-link" href="{{route('squad.select')}}">select squad</a>
                    @else
                    <a class="btn disabled" href="{{route('squad.select')}}" disabled>select squad (closed)</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if($settings['transfer_window_open'])
                    <a class="nav-link" href="{{route('transfer')}}">transfer</a>
                    @else
                    <a class="btn disabled" href="{{route('transfer')}}" disabled>transfer (closed)</a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" onClick="logout()">Logout</a>
                    <form action="{{route('logout')}}" id="logout" method="post">
                        @csrf
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
                @endauth
            </ul>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function logout() {
            document.getElementById('logout').submit();
        }
    </script>
</body>

</html>
