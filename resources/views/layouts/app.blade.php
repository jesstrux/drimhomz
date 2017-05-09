<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Mobile -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">

    <!-- Chrome / Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fefefe">
    <link rel="icon" hre="icon.png">

    <!-- Safari / iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon-precomposed" hre="apple-touch-icon.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="{{asset('css/flex.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('js/jquery.webui-popover.min.js')}}"></script>
    <script src="{{asset('js/web-animations.min.js')}}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token()
        ]); ?>

        var _token = '<?php echo csrf_field(); ?>';
        var base_url = "<?php echo $base_url?>";
        var house_base_url = "<?php echo $house_url?>";
        var shop_base_url = "<?php echo $shop_url?>";
        var product_base_url = "<?php echo $product_url?>";
        var office_base_url = "<?php echo $office_url?>";
        var user_base_url = "<?php echo $user_url?>";
        var ad_base_url = "<?php echo $banner_url?>";
        var home_base_url = "<?php echo $home_url?>";
        var rental_base_url = "<?php echo $rental_url?>";
        var plot_base_url = "<?php echo $plot_url?>";
        var drimMode = false;
        var commentEditMode = false;
        var user_exists = <?php echo Auth::guest() ? "false" : "true" ?>;
        function getPopup(el){
            console.log("El is: " + el);
            return "A popover is showing here";

            // var el = e.target;
            cur_popup_area = el;

            id = $(el).data("user-id");
            console.log("Foun it: " + id);
            if(!id)
              return;
          // +id
            return $.get("/userProfilePopup/1", function (response) {
                // cur_popup = $(response);
                // console.log(el);
                // cur_popup.css({left: e.clientX - 140, top: e.clientY - 200});
                // $('body').append(cur_popup);
                return response;
            });
        }

        function showLoading(){
            document.body.classList.add('page-loading');
        }

        function hideLoading(){
            document.body.classList.remove('page-loading');
        }
    </script>
    <script src="{{asset('js/main.js')}}"></script>
    <style>
        body.page-loading{
            overflow: hidden !important;
        }
        #pageLoader{
            position: fixed;
            top: 0; left: 0;
            right: 0; bottom: 0;
            background: rgba(0,0,0,0.06);
            z-index: 9999999;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            -ms-align-items: center;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
        }
        body.page-loading #pageLoader{
            opacity: 1;
            pointer-events: auto;
        }

        .loader {
          margin: 100px auto;
          font-size: 25px;
          width: 1em;
          height: 1em;
          border-radius: 50%;
          position: relative;
          text-indent: -9999em;
          -webkit-animation: load5 1.1s infinite ease;
          animation: load5 1.1s infinite ease;
          -webkit-transform: translateZ(0);
          -ms-transform: translateZ(0);
          transform: translateZ(0);
        }
        @-webkit-keyframes load5 {
          0%,
          100% {
            box-shadow: 0em -2.6em 0em 0em #ffa500, 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.5), -1.8em -1.8em 0 0em rgba(255,165,0, 0.7);
          }
          12.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.7), 1.8em -1.8em 0 0em #ffa500, 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.5);
          }
          25% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.5), 1.8em -1.8em 0 0em rgba(255,165,0, 0.7), 2.5em 0em 0 0em #ffa500, 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          37.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.5), 2.5em 0em 0 0em rgba(255,165,0, 0.7), 1.75em 1.75em 0 0em #ffa500, 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          50% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.5), 1.75em 1.75em 0 0em rgba(255,165,0, 0.7), 0em 2.5em 0 0em #ffa500, -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          62.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.5), 0em 2.5em 0 0em rgba(255,165,0, 0.7), -1.8em 1.8em 0 0em #ffa500, -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          75% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.5), -1.8em 1.8em 0 0em rgba(255,165,0, 0.7), -2.6em 0em 0 0em #ffa500, -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          87.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.5), -2.6em 0em 0 0em rgba(255,165,0, 0.7), -1.8em -1.8em 0 0em #ffa500;
          }
        }
        @keyframes load5 {
          0%,
          100% {
            box-shadow: 0em -2.6em 0em 0em #ffa500, 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.5), -1.8em -1.8em 0 0em rgba(255,165,0, 0.7);
          }
          12.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.7), 1.8em -1.8em 0 0em #ffa500, 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.5);
          }
          25% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.5), 1.8em -1.8em 0 0em rgba(255,165,0, 0.7), 2.5em 0em 0 0em #ffa500, 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          37.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.5), 2.5em 0em 0 0em rgba(255,165,0, 0.7), 1.75em 1.75em 0 0em #ffa500, 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          50% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.5), 1.75em 1.75em 0 0em rgba(255,165,0, 0.7), 0em 2.5em 0 0em #ffa500, -1.8em 1.8em 0 0em rgba(255,165,0, 0.2), -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          62.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.5), 0em 2.5em 0 0em rgba(255,165,0, 0.7), -1.8em 1.8em 0 0em #ffa500, -2.6em 0em 0 0em rgba(255,165,0, 0.2), -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          75% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.5), -1.8em 1.8em 0 0em rgba(255,165,0, 0.7), -2.6em 0em 0 0em #ffa500, -1.8em -1.8em 0 0em rgba(255,165,0, 0.2);
          }
          87.5% {
            box-shadow: 0em -2.6em 0em 0em rgba(255,165,0, 0.2), 1.8em -1.8em 0 0em rgba(255,165,0, 0.2), 2.5em 0em 0 0em rgba(255,165,0, 0.2), 1.75em 1.75em 0 0em rgba(255,165,0, 0.2), 0em 2.5em 0 0em rgba(255,165,0, 0.2), -1.8em 1.8em 0 0em rgba(255,165,0, 0.5), -2.6em 0em 0 0em rgba(255,165,0, 0.7), -1.8em -1.8em 0 0em #ffa500;
          }
        }

        body:not(.open-menu) #mobNavOpener i:last-child{
            display: none;
        }

        body.open-menu #mobNavOpener i:first-child{
            display: none;
        }

        @media only screen and (max-width: 760px) {
            body #mainContent,
            body #mainestNav{
                -webkit-transition: transform 0.15s;
                -moz-transition: transform 0.15s;
                -ms-transition: transform 0.15s;
                -o-transition: transform 0.15s;
                transition: transform 0.15s;
            }

            body.open-menu{
                overflow: hidden;
                padding-top: 0;
            }

            body.open-menu #mainContent,
            body.open-menu #mainestNav{
                box-shadow: -1px 0 10px rgba(0,0,0,0.24);
                -webkit-transform: translateX(250px);
                -moz-transform: translateX(250px);
                -ms-transform: translateX(250px);
                -o-transform: translateX(250px);
                transform: translateX(250px);


                -webkit-transition: transform 0.25s;
                -moz-transition: transform 0.25s;
                -ms-transition: transform 0.25s;
                -o-transition: transform 0.25s;
                transition: transform 0.25s;
            }

            body.open-menu #mainContent{
                height: 110vh;
                padding-top: 70px;
            }
            #outerContent{
                background-color: inherit;
            }
        }
    </style>
</head>
<body class="open-searc" style="backgroun: #eee !important;" id="body">
<div id="pageLoader">
    <div style="width: 230px; height: 230px; transform: scale(0.6)">
        <div class="loader"></div>
    </div>
</div>

<div id="siteContent" style="position: relative;">
    @include('layouts.mobile-nav')

    <div id="outerContent">
        @include('layouts.header')

        <div id="mainContent">
            @yield('content')
        </div>
    </div>
</div>

@include('layouts.footer')
@include('home.house-preview')
@include('home.ad-preview')
@include('project.new-project')
@include('houses.new-house')
<div id="userBottomSheet" class="cust-modal hidden visible-xs visible-sm" style="-ms-align-items: flex-end;align-items: flex-end; background-color: rgba(0,0,0,0.5)" onclick="hideUserBottomSheet()">
    <div class="cust-modal-content" style="height: auto; position: absolute; bottom: 0; padding-bottom: 80px; box-shadow: 0 -10px 6px rgba(0,0,0,0.4);">
        <?php $user = Auth::user(); ?>
        {{--@include('user.profile_bottom_sheet')--}}
    </div>
</div>

<?php
$auth_user = null;
$user_projects = null;
if(!Auth::guest()){
    $auth_user = Auth::user();
    $user_projects = $auth_user->projects;
}
?>

@if(isset($auth_user) && $auth_user != null)
    @include('home.new-pin')
@endif

<!-- Scripts -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/iziToast.min.js')}}"></script>
<script>
    function showUserBottomSheet(){return;}

    function showToast(type, msg, time){
        var timeout = 1200;
        if(time)
            timeout = time;

        if(type == "success"){
            iziToast.success({
                title: 'Success',
                message: msg,
                position: 'topRight',
                timeout: timeout
            });
        }else{
            iziToast.error({
                title: 'Error',
                message: msg,
                position: 'topRight',
                timeout: timeout
            });
        }
    }

    $(document).ready(function(){
        var curr_url = window.location.href;
        var route_name = curr_url.substr(curr_url.lastIndexOf('/') + 1);
        <?php if(Auth::check()){?>

        var verified ={{ Auth::user()->verified}};
        <?php }else{?> var verified = true;<?php }?>


        if(!verified&&route_name!='verifyPhoneNumber') {
            iziToast.info({
                title: 'Reminder!',
                message: 'Please verify your phone number!',
                position: 'topLeft',
                timeout: false,
                close:false,
                drag:false,
                buttons: [

                    ['<button>Click Here</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOutUp' }, toast);
                        window.location.href = '/verifyPhoneNumber';
                    }]
                ]
            });
        }
    });

    // window.Echo = new Echo({
    //     broadcaster: 'pusher',
    //     key: '813712e6e7edfc7d0978'
    // });

    // var userId = <php echo Auth::guest() ? 1 : Auth::user()->id; ?>

    // Echo.private('App.User.' + userId)
    //         .notification((notification) => {
    //     console.log(notification.type);
    // });
</script>
</body>
</html>
