<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield("title")</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="https://kit.fontawesome.com/c3869bc416.js"></script>
</head>
<body>
  <div id="app">
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="/catalog">Catalog</a>
      @auth
      @if(Auth::user()->role_id == 2)
      <a href="/admin/showAddItemForm">Add Item</a>
      <a href="/admin/showAllUsers">Users</a>
      <a href="/admin/showAllOrders">Requests</a>
      @elseif(Auth::user()->role_id == 1)
      <a href="/myProfile/{{Auth::user()->id}}">My Profile</a>
      <a href="/myOrders">Reservations</a>
      @else
      @endif
      @endauth
      
      <a href="/about">About Us</a>
      
      @guest
      <li>
        <a href="{{ route('login') }}">{{ __('Login') }}</a>

        @if (Route::has('register'))

        <a href="{{ route('register') }}">{{ __('Register') }}</a>

        @endif
      </li>
      @else
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-center" aria-labelledby="navbarDropdown">
          <a class="dropdown-item text-dark" href="{{ route('logout') }}"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
    @endguest
  </div>

  <!-- Use any element to open the sidenav -->
  <nav id="nav" class="navbar navbar-expand-md navbar-dark navbar-fixed-top navbar-inner">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <i class="fas fa-tv"></i> <strong>Tyme</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
        <ul class="navbar-nav mr-auto">
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          <li class="nav-item nav-link text-white" onclick="openNav()" id="siteMap"><strong>Site Map</strong></li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="main">
    @yield('content')
  </div>
  <footer>
    <div class="container" id="footer">
      <div class="d-flex justify-content-center align-items-center">
        <p class="text-white"><strong>All Rights Reserved 2019 &copy;</strong></p>
      </div>
    </div>
  </footer>
  <script>
    /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
    function openNav() {
      document.getElementById("siteMap").style.visibility = "hidden";
      document.getElementById("mySidenav").style.width = "200px";
      document.getElementById("main").style.marginRight = "200px";
      document.getElementById("nav").style.marginRight = "200px";
      document.getElementById("footer").style.marginRight = "200px";
      document.getElementById("myBtn").style.marginRight = "50px";
      document.getElementById("About").style.marginRight = "10px";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
    function closeNav() {
      document.getElementById("siteMap").style.visibility = "visible";
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("main").style.marginRight = "0";
      document.getElementById("nav").style.marginRight = "0";
      document.getElementById("footer").style.marginRight = "auto";
      document.getElementById("myBtn").style.marginRight = "0";
      document.getElementById("About").style.marginRight = "0";
    }
  </script>
</div>
</body>
</html>
