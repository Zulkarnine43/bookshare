
  <div class="top-header">
    <div class="container">
      <div class="dropdown float-right">
        <a class="dropdown-toggle pointer top-header-link" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user"></i> My Account
        </a>      
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          @if(Auth::check())
                <a class="dropdown-item" href="{{route('users.profile', Auth::user()->username )}}">Profile</a>
                <a class="dropdown-item" href="{{route('users.dashboard',Auth::user()->username)}}">Dashboard</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          @else
            <a class="dropdown-item" href="{{route('register')}}">Sign Up</a>  
            <a class="dropdown-item" href="{{route('login')}}">Sign In</a>  
          @endif       
        </div>
      </div>     
      <div class="float-right">
        @if(Auth::check())
        <div class="">
          {{-- <a href="{{route('wishlist',Auth::id())}}" class="top-header-link"><span class="fa fa-heart btn btn-success" style="color: red;"></span> wishlist</a> --}}
         <a href="{{route('wishlist')}}" class="top-header-link"><span class="fa fa-heart btn btn-success" style="color: red;"></span> wishlist</a>
        </div>
        @endif
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="main-navbar">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand mr-5" href="{{ route('index') }}">
          <img src="{{ asset('images/logo.jpg') }}" class="logo-image">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('books.index')}}">Recent Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('books.upload')}}">Upload Book</a>
            </li>
          </ul>
              <form class="form-inline my-2 my-lg-0" action="{{route('books.search')}}" method="GET">
                <input class="form-control mr-sm-2 search-form" type="text" placeholder="Search" name="s" aria-label="Search" value="{{ isset($searched) ? $searched:''}}">
                <button class="btn btn-secondary my-2 my-sm-0 search-button" type="submit"><i class="fa fa-search"></i></button>
              </form>
        </div>
      </div>
    </nav>
  </div>