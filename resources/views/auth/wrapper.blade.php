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
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/flex.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('bower_components/intl-tel-input/build/css/intlTelInput.css')}}"/>
</head>
<body>
    <div class="layout center-center" style="height: 100vh">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script src="{{asset('bower_components/intl-tel-input/build/js/intlTelInput.min.js')}}"></script>
    <script>
        var telInput = $(".phoneNumber"),
          errorMsg = $("#error-msg"),
          validMsg = $("#valid-msg");

        // initialise plugin
        telInput.intlTelInput({
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
          utilsScript: "bower_components/intl-tel-input/build/js/utils.js"
        });

        var reset = function() {
          telInput.removeClass("error");
          errorMsg.addClass("hide");
          validMsg.addClass("hide");
        };

        // on blur: validate
        telInput.blur(function() {
          reset();
          if ($.trim(telInput.val())) {
            if (telInput.intlTelInput("isValidNumber")) {
              validMsg.removeClass("hide");
            } else {
              telInput.addClass("error");
              errorMsg.removeClass("hide");
            }
          }
        });

        // on keyup / change flag: reset
        telInput.on("keyup change", reset);
        function setPhone(){
            var extension = $("#phone_no").val($(".phoneNumber").intlTelInput("getNumber"));
            console.log(extension);
        }

    </script>
</body>
</html>
