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
    <script src="{{asset('js/jquery.webui-popover.min.js')}}"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        var house_base_url = "<?php echo $house_url?>";
        var user_base_url = "<?php echo $user_url?>";
        var ad_base_url = "<?php echo $banner_url?>";

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
    </script>
    <script src="{{asset('js/main.js')}}"></script>
</head>
<body>
    <div id="mainContent">
        @yield('content')
    </div>

    @include('layouts.footer')
    <!-- Scripts -->

    <?php
        $auth_user = null;
        $user_projects = null;
        if(!Auth::guest()){
            $auth_user = Auth::user();
            $user_projects = $auth_user->projects;
        }
    ?>

    @if(isset($auth_user) && $auth_user != null)
        <div id="newPinModal" class="cust-modal">
            <button class="closer" onclick="closeNewPin()">
                <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <div class="cust-modal-content" style="width: 700px; transform: none; opacity: 1; padding: 30px;">
                <div class="row">
                    <div class="col col-sm-5" style="border-right: 1px solid #eee; padding-top: 20px; padding-bottom: 20px; margin-top: 60px;">
                        <div id="newPinCard" style="background-color: #ddd; width: calc(100% - 20px); height: 250px; margin-right: 20px;">
                        </div>
                    </div>

                    <div class="col col-sm-7" style="position: relative;overflow-x: hidden; height: 400px;">
                        <div class="hidden" style="position: absolute; height: 100%; width: 100%; background: #fff;box-shadow: -2px 0 1px rgba(0,0,0,0.26); -webkit-transform: translateX(100%);-ms-transform: translateX(100%);-o-transform: translateX(100%);transform: translateX(100%);">
                            <button style="position: absolute; right: 10px; top: 10px">
                                <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            </button>

                            <h3>New project</h3>
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$auth_user->id}}">

                            <label>Project title</label>
                            <input name="title" type="text" placeholder="enter project title here" required>
                            <button type="submit" onclic="addnewPin('/createProject')">CREATE</button>
                        </div>
                        
                        <div style="padding: 20px;">
                            <div>
                                <h5 style="display: inline-block; font-size: 23px; margin-top: 1px;">Choose project</h5>
                                <button type="submit" onclic="addnewPin('/createProject')">Create project</button>
                            </div>
                            <hr>
                            <div id="projectOptions">
                                @if($user_projects != null)
                                    @foreach($user_projects as $proj)
                                        <label for="proj{{$loop->iteration}}" style="padding: 12px; background-color: #eee">
                                            <form id="newPin{{$loop->iteration}}" method="POST" action="/createPin" class="layout">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="project_id" id="proj{{$loop->iteration}}" value="{{$proj->id}}">
                                                <div class="flex">
                                                    {{$proj->title}}
                                                </div>
                                                    
                                                <button class="btn" type="submit" onclic="addnewPin('/createProject')">
                                                    SAVE
                                                </button>
                                            </form>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif    
    <script>
        function closeNewPin() {
            $("#newPinModal").removeClass("open");
            $("body").removeClass("locked");
        }

        function openNewPin($jqel) {
            $("#newPinModal").addClass("open");
            $("body").addClass("locked");
            el = $jqel.get(0);
            var src = $jqel.find(".image img").attr("src");

            var previewCard = document.querySelector("#newPinCard");
            var previewBox = previewCard.getBoundingClientRect();
            var elBox = el.getBoundingClientRect();
            
            var translateX = (elBox.left + (elBox.width / 2)) - (previewBox.left + (previewBox.width / 2));
            var translateY = (elBox.top + (elBox.height / 2)) - (previewBox.top + (previewBox.height / 2));
            var translate = 'translate(' + translateX + 'px,' + translateY + 'px)';
            var size = Math.max(previewBox.width + Math.abs(translateX) * 2, previewBox.height + Math.abs(translateY) * 2);
            var diameter = Math.sqrt(2 * size * size);
            var scaleX = diameter / previewBox.width;
            var scaleY = diameter / previewBox.height;
            var scale = 'scale(' + scaleX + ',' + scaleY + ')';
            var transform = scale + " " + translate;
            previewCard.style.transformOrigin = previewCard.style.webkitTransformOrigin = "50% 50%";
            previewCard.style.backgroundPosition = "center";
            previewCard.style.backgroundSize = "cover";
            previewCard.style.backgroundImage = "url("+src+")";
            
            var animation = previewCard.animate([
                {opacity: 0, transform: translate + "scale(0)"},
                {opacity: 1.0, transform: "none"}
            ], {
                duration: 150,
                delay: 50
            });
        }

        function addnewPin(url){
            var formdata = new FormData($("#newPin")[0]);
            $.ajax({
                  type:'POST',
                  url: url,
                  data: formdata,
                  dataType:'json',
                  async:false,
                  processData: false,
                  contentType: false
            })
            .done(function(response){
                console.log("Response!, ", response);
                if(response.success){
                    closenewPin();
                    infoSaved("Project created!");
                }
            })
            .fail(function(response){
                console.log("Error!, ", response);
                document.write(response.responseText);
            })
            .always(function(){
                console.log("Action done");
            });
        }
    </script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
