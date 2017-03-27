<nav id="mainestNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container" style="padding-right: 20px; position: relative;">
        <div class="navbar-header" style="position: relative;">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="hidden-x" src="{{asset('images/drimhomzlogo.png')}}" alt="">
                <span id="logo">{{ config('app.name', 'Drimhomz') }}</span>
            </a>

            <button class="search-opener hidden-sm hidden-md hidden-lg hidden-xl" style="position: relative;" onclick="openSearchBar()">
                <svg fill="#555" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul id="mainNav" class="nav navbar-nav navbar-right" style="position: relative;">
                <?php
                    $isadmin = false;

                    if(!Auth::guest()){
                        if(Auth::user()->role == "admin")
                            $isadmin = true;
                    }
                ?>
                @if ($isadmin)
                    <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                @endif
                
                @if (Auth::guest())
                    <li><a href="{{ url('/') }}">Home</a></li>
                @else
                    <li><a href="{{ url('/home') }}">Home</a></li>
                @endif
                
                <!-- <li><a href="about">About</a></li> -->
                <li><a href="{{ url('/shop') }}">Shop</a></li>
                <li><a href="{{ url('/expert') }}">Expert</a></li>
                <li><a href="{{ url('/advice') }}">Advice</a></li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->full_name() }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?php
                                    $profileUrl = "/user/".Auth::user()->id;
                                ?>
                                <a href="{{ url($profileUrl) }}">
                                    Profile
                                </a>
                            </li>
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

                <button class="search-opener hidden-xs" style="position: relative;" onclick="openSearchBar()">
                    <svg fill="#555" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                </button>
            </ul>
        </div>

        <div id="searchBar" class="layout vertical">
            <form action="{{url('search/')}}" class="layout center">
                <button type="button" onclick="closeSearchBar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                </button>

                <input class="flex" name="q" type="search" placeholder="Search" required autocomplete="off">

                <span>Enter to search</span> &emsp;

                <button type="button" class="search-clearer" onclick="emptySearchBar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
            </form>

            <div id="searchResults">
                <div id="loader" class="layout center-center" style="text-align: center; height: 100%; position: relative; padding: 10px;">
                    <img src="{{asset('img/loading.gif')}}" alt="">
                </div>

                <div id="results">
                    
                </div>
            </div>
        </div>
    </div>
</nav>