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
        var user_base_url = "<?php echo $user_url?>";
        var ad_base_url = "<?php echo $banner_url?>";
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
    </style>
</head>
<body class="open-searc" style="backgroun: #eee !important;">
<div id="pageLoader">
    <div style="width: 230px; height: 230px; transform: scale(0.6)">
        <div class="loader"></div>
    </div>
</div>

@include('layouts.header')

<div id="mainContent">
    @yield('content')
</div>
<div id="userBottomSheet" class="cust-modal hidden visible-xs visible-sm" style="-ms-align-items: flex-end;align-items: flex-end; background-color: rgba(0,0,0,0.5)" onclick="hideUserBottomSheet()">
    <div class="cust-modal-content" style="height: auto; position: absolute; bottom: 0; padding-bottom: 80px; box-shadow: 0 -10px 6px rgba(0,0,0,0.4);">
        <div class="user-loader layout vertical center-center" style="text-align: center; padding: 10px;">
            <img src="{{asset('images/loading.gif')}}" alt="" style="width:60px; margin-top: 18px;">
            <p style="font-size: 1.4em; margin-top: 15px;">Loading...</p>
        </div>

        <div class="the-profile"></div>
    </div>
</div>

@include('layouts.footer')
@include('home.house-preview')
@include('home.ad-preview')
@include('project.new-project')
@include('houses.new-house')

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

    function hideUserBottomSheet(){
        $("#userBottomSheet .cust-modal-content").addClass("peeking");
        setTimeout(function(){
            $("#userBottomSheet .cust-modal-content").removeClass("peeking");
            $("#userBottomSheet").removeClass("open");
            $("#userBottomSheet .the-profile").html("");
            $("body").removeClass("locked");
        },100);
    }

    function showUserBottomSheet(userid){
        $("#userBottomSheet").addClass("open loading");
        $("body").addClass("locked");
        $.get(base_url + '/userProfilePopup/' + userid,function(res){
            console.log(res);
            $("#userBottomSheet").removeClass("loading");
            $("#userBottomSheet .the-profile").html(res);
        });
    }

    $(document).ready(function(){
        $(document).on("click", '.tangazo', function(e){
            e.preventDefault();
            var ad = $(this).index() == 0 ? cur_idx_left : cur_idx_right;
            openAd(random_ads[ad]);
        });
    });
</script>
</body>
</html>
