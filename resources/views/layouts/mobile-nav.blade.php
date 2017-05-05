<style>
    #mainMobNav{
        padding: 26px 0;
        background-color: #f0f0f0;
        position: fixed;
        top:0;
        left:0;
        height: 100vh;
        overflow-y: auto;
        min-width: 250px;

        -webkit-transition: all 0.2s;
        -moz-transition: all 0.2s;
        -ms-transition: all 0.2s;
        -o-transition: all 0.2s;
        transition: all 0.2s;
    }
    body:not(.open-menu) #mainMobNav{
        opacity: 0;
        pointer-events: none;

        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        -o-transform: translateX(-50%);
        transform: translateX(-50%);
    }
    #mainMobNav a{
        color: inherit;
        text-decoration: none;
        display: block;
        padding: 16px 26px;
        font-size: 1.4em;
    }
    #mainMobNav a.active{
        border-left: 4px solid #ee9900;
        background-color: rgba(0,0,0,0.04);
    }

    @media only screen and (max-width: 760px) {
        #mainMobNav{
            display: inline-block;
        }
    }
</style>
<aside id="mainMobNav" class="hidden visible-xs" onclick="toggleMenu()">
    <a href="{{ url('/') }}" class="layout center-center">
        Home
    </a>
    @if (Auth::guest())
        <a href="{{ url('/notifications') }}">
            Notifications
        </a>
    @endif


    @role('admin')
        <a href="{{ url('/dashboard') }}">Dashboard</a>
    @endrole

    <!-- <li><a href="about">About</a></li> -->
    {{--<li><a href="{{ url('/shop') }}">Shop</a></li>--}}
    <a href="{{ url('/expert') }}">Expert</a>
    <a href="{{ url('/advice') }}">Advice</a>
    <a href="{{ url('/realhomz') }}">Realhomz</a>
    <a href="{{ url('/notifications') }}">Nofications&nbsp;
        <span class="badge style-danger">@if(Auth::user() && Auth::user()->unreadNotifications->count() > 0){{Auth::user()->unreadNotifications->count()}}@endif</span>
    </a>
</aside>