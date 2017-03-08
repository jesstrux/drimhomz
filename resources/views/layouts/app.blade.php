<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="{{asset('css/flex.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        var house_base_url = "<?php echo $house_url?>";
        var user_base_url = "<?php echo $user_url?>";
        var ad_base_url = "<?php echo $banner_url?>";
    </script>
    <script src="{{asset('js/main.js')}}"></script>
</head>
<body>
    <div id="mainContent">
        @yield('content')
    </div>

    @include('layouts.footer')
    <!-- Scripts -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
