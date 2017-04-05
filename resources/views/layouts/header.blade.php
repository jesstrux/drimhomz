<nav id="mainestNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container" style="padding-right: 20px; position: relative;">
        <div class="navbar-header" style="position: relative;">
            @if(isset($has_menu) && $has_menu)
                <button onclick="openMenu()" style="float: left; margin-left: 8px; margin-right: 0; height:60px; border: none; background-color: transparent; position: relative;" class="btn btn-default hidden visible-xs">
                    <i style="font-size: 25px" class="fa fa-bars"></i>
                </button>
            @endif

            <button type="button" class="navbar-toggle collapsed hidden-xs" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="hidden-x" src="{{asset('images/drimhomzlogo.png')}}" alt="">
                <span id="logo">{{ config('app.name', 'Drimhomz') }}</span>
            </a>

            <div id="mobAuthLinks" class="layout center">
                @if (Auth::guest())
                    <a href="{{ url('/login') }}">Login</a>
                @else
                    @if(!isset($is_my_profile))
                        <a href="javascript:void(0);" class="layout center-center" onclick="openSearchBar()">
                            <svg fill="#555" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        </a>
                    @endif

                    <?php
                        $notifications = Auth::user()->notifications;
                        $unread_count = Auth::user()->unreadNotifications->count();
                    ?>

                    <a href="{{ url('/notifications') }}" class="layout center-center" onclic="openNotifications()" style="position: relative;">
                        <span style="line-height: 1; padding: 3px 8px; padding-bottom: 5px; border-radius: 12px; display: inline-block; align-self: flex-start ;background-color: #ffa500; position: absolute; top: 12px; right:2px; font-size: 14px; color: #000">{{$unread_count}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M11.5 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6.5-6v-5.5c0-3.07-2.13-5.64-5-6.32V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5v.68c-2.87.68-5 3.25-5 6.32V16l-2 2v1h17v-1l-2-2z"/></svg>
                    </a>

                    @include('notifications.wrapper')

                    <?php
                        $profileUrl = "/user/".Auth::user()->id;
                    ?>
                    @if(!isset($is_my_profile))
                        <a class="layout center-center" href="{{ url($profileUrl) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </a>
                    @else
                        <a class="layout center-center" href="{{ url('/setupAccount') }}" style="font-weight: bold;">
                            EDIT
                        </a>

                        <a class="layout center-center" href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42C17.99 7.86 19 9.81 19 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.19 1.01-4.14 2.58-5.42L6.17 5.17C4.23 6.82 3 9.26 3 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.74-1.23-5.18-3.17-6.83z"/></svg>
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul id="mainNav" class="nav navbar-nav navbar-right" style="position: relative;">
                <li style="margin-right: 9px;">
                    <button class="search-opener pull-right hidden-xs" style="position: relative;" onclick="openSearchBar()">
                        <svg fill="#555" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                </li>
                @if(!Auth::guest())
                    <?php
                    $notifications = Auth::user()->notifications;
                    $unread_count = Auth::user()->unreadNotifications->count();
                    ?>
                    @include('notifications.wrapper')
                @endif
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
                {{--<li><a href="{{ url('/shop') }}">Shop</a></li>--}}
                {{--<li><a href="{{ url('/expert') }}">Expert</a></li>--}}
                {{--<li><a href="{{ url('/advice') }}">Advice</a></li>--}}

                <li><a href="{{ url('/realhomz') }}">Realhomz</a></li>
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
            </ul>
        </div>

        <div id="searchBar" class="layout vertical">
            <form action="{{url('search/')}}" class="layout center">
                <button type="button" onclick="closeSearchBar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                </button>

                <input class="flex" name="q" type="search" placeholder="Search" required autocomplete="off">

                <span class="hidden-xs">Enter to search</span> &emsp;

                <button type="button" class="search-clearer" onclick="emptySearchBar()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
            </form>
        </div>

        <div id="searchResults">
            <div id="loader" class="layout center-center" style="text-align: center; height: 100%; position: relative; padding: 10px;">
                <img src="{{asset('img/loading.gif')}}" alt="">
            </div>

            <div id="results">

            </div>
        </div>
    </div>
</nav>