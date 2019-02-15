<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ URL::to('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

</head>

<body>
    @yield('header')
    <nav class="navbar navbar-expand-md bg-light navbar-light">
        <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav d-flex flex-fill justify-content-between">

                @if (Auth::guest())
                <div class="d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url( '/login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url( '/register') }}">Register</a>
                    </li>
                </div>
                @else

                <div class="d-flex">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('goals.index') }}">Goals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('foods.index') }}">Food</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('diaries.index') }}">Diary</a>
                    </li>
                </div>


                <div class="d-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                   {{ Auth::user()->name }}
                  </a>
                        <div class="dropdown-menu">
                            <a class="pl-2" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </div>
                @endif

            </ul>
        </div>
    </nav>
    @include('flash') @yield('content')
    <script src="{{ URL::to('js/app.js') }}"></script>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
</body>

</html>