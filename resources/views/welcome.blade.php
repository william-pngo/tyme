<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cambay&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c3869bc416.js"></script>

    <!-- Styles -->
    <style>
    html, body {
        background-color: #fff;
        color: white;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
        background-size: cover;
    }

    nav {
        width: 100%;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 104px;
    }

    .links > a {
        color: #fff;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    @keyframes blink { 50% { border-color: #778899; } }

    .link > a {
        color: #fff;
        padding: 5px 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        border: 3px solid;
        animation: blink .5s step-end infinite alternate;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    #myVideo {
      position: fixed;
      right: 0;
      bottom: 0;
      min-width: 100%; 
      min-height: 100%;
  }
</style>
</head>
<body>
    <video autoplay muted loop autobuffer id="myVideo">
        <source src="/video/star.mov" type="video/mp4">
        </video>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            <div class="top-right links" style="font-family: 'Nunito', sans-serif;">
                @auth
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fas fa-tv"></i> Tyme <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if(Auth::user()->role_id == 2)
                    <a class="dropdown-item" href="/admin/showAddItemForm">Add Item</a>
                    <a class="dropdown-item" href="/admin/showAllUsers">Users</a>
                    <a class="dropdown-item" href="/admin/showAllOrders">Requests</a>
                    @else
                    <a class="dropdown-item" href="/catalog">Catalog</a>
                    <a class="dropdown-item" href="/myProfile/{{Auth::user()->id}}">My Profile</a>
                    <a class="dropdown-item" href="/myOrders">Reservation List</a>
                    @endif
                    <a class="dropdown-item" href="/about">About Us</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                @auth
                Welcome Back, {{Auth::user()->name}}
                @else
                <i class="fas fa-tv"></i> Tyme
                @endauth
            </div>
            <div class="link">
                @auth
                @if(Auth::user()->role_id == 2)
                <a href="/catalog">See The Current Catalog List</a>
                @else
                <a href="/catalog">Check Out Your Favorite Shows NOW!</a>
                @endif
                @endauth
                @guest
                <a href="/catalog">Check Out Your Favorite Shows NOW!</a>
                @endguest
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
