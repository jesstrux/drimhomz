<style>
    #newHouse{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newHouse .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        width: 650px;
    }
    #newHouse #houseImageContainer{
        position: relative; width: 450px;
        margin-right: 40px;
        padding: 0 10px;
    }
    #newHouse #houseInfoContainer{
        position: relative; width: 600px;
    }
    #camera-img, #camera-video {
      width: 100vw;
      height: 360px;
      position: relative;
    }

    #camera-img, #camera-canvas {
      position: absolute;
      top: 0;
      left: 0;
      display: none;
    }

    #camera-video {
      background: rgba(0,0,0,0.25);
    }

    #camera-take, #camera-retake, #camera-flip{
      position: absolute;
      left: 43%;
      left: calc(50% - 28px);
      bottom: 20px;
      cursor: pointer;
      border: 3px solid rgba(255, 255, 255, 0.7);
      border-radius: 50%;
      background: rgba(0,0,0,0.5);
      width: 56px;
      padding: 3px;
      height: 56px;
      text-align: center;
    }

    #camera-take img, #camera-retake img, #camera-flip img {
      width: 30px;
      margin: 4px 0;
      /*margin: 4px 14px 0 5px;*/
    }

    #camera-retake {
      display: none;
    }

    #camera-flip{
        width: 40px;
        height: 40px;
        border: none;
        background-color: rgba(255, 255, 255, 0.7);
        top: 5%;
        left: 5%;
    }

    #camera-flip img{
        
    }

    @media only screen and (max-width: 760px) {
        #newHouse .cust-modal-content{
            padding: 20px;
            padding-top: 18px;
            border-radius: 0;
            box-shadow: none;
            width: 100%;
            height: 100vh;
            overflow-y: auto;
        }
        #newHouse #newHouseWrapper{
            flex-direction: column;
        }
        #newHouse #houseImageContainer{
            position: relative;
            margin-right: 0;
            padding: 0 10px;
        }
        #newHouse #houseInfoContainer,
        #newHouse #houseImageContainer{
            padding: 0;
            width: 100%;
        }
    }
</style>
<div id="newHouse" class="cust-modal">
    <div class="hidden visible-xs cust-modal-toolbar" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewHouse()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Dream</h5>

            <button style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;" class="btn" type="button" onclick="saveHouse()">CREATE</button>
        </div>
    </div>

    <div class="cust-modal-content" style="display: inline-block; position: relative;">
        <a class="close hidden-xs" onclick="closeNewHouse()" style="position: absolute !important; right: 20px !important; top: 20px !important;">
            <svg fill="#000" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
        </a>

        @if(!Auth::guest())
            <?php 
                $user = Auth::user();
                $projects = $user->projects;
                $project_count = $projects->count();
            ?>
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100vh; height: calc(100vh - 55px); background: #6a1" class="layout center-center hidden visible-x">
                <div id="camera">
                    
                </div>
            </div>

            <form id="createHouseForm" enctype="multipart/form-data" onsubmit="saveHouse()" method="POST" action="/createHouse" style="width: 100%; padding-top: 15px;">
                <h3 class="cust-modal-title">New Dream</h3>
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{$user->id}}">

                <div id="newHouseWrapper" class="layout">
                    <div id="houseImageContainer">
                        <img id="houseImage" src="" alt="" style="width: 100%; height: 250px; background-color: #ddd; margin: 15px auto; margin-bottom: 25px; display: inline-block; border: none">
                        <label style="margin-bottom: 8px;">Dream image</label>
                        <input style="margin-bottom: 10px;" onchange="showImage(this)" accept="images/*" name="image_url" type="file" required><br>
                    </div>

                    <div id="houseInfoContainer" clas="flex">
                        @if(!isset($the_project))
                            @if(!is_null($project_count))
                                <label>Select a project</label>
                                <select name="project_id" required>
                                    <option value="">Choose an option</option>

                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">
                                            {{$project->title}}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <label>Project title</label>
                                <input type="text" name="project_title" required>
                            @endif
                        @else
                            <input type="hidden" name="project_id" value="{{$the_project->id}}">
                        @endif

                        <label>Title</label>
                        <input name="title" type="text" placeholder="enter dream title here" required>

                        <label style="margin-bottom: 8px;">Description</label>
                        <textarea rows="3" name="description" placeholder="Enter some description" required></textarea><br>

                        <button type="submit" class="hidden-xs">CREATE</button>
                    </div>
                </div>
            </form>
        @else
            <p>
                Please <a href="{{url('/login')}}">LOGIN</a>
                to create a new dream.
            </p>
        @endif
    </div>    
</div>
<div id="forMob" style="position: absolute; opacity: 0; pointer-events:  none;"></div>
<script src="{{asset('js/jquery.camera.js')}}"></script>
<script>
    $(document).ready(function(){
        function takePhoto(){
          if($("#forMob").css('display') != "none"){
          console.log("For mob" + $("#forMob").css('display'));
            $("#camera").camera({
              resolution: "QVGA", // "QVGA", "VGA", "HD"
              snap: function(result){
                kunaNewPic(result);
              },
              reset: function(result){
                console.log(result);
              },
              flip: function(facing){
                onFlip(facing);
              }
            });
          }
        }
    });

    function kunaNewPic(res){
        console.log(res);
    }

    function onFlip(facing){
        $("#camera").camera({
            turn: facing,
            resolution: "QVGA", // "QVGA", "VGA", "HD"
            snap: function(result){
                kunaNewPic(result);
            },
            reset: function(result){
                console.log(result);
            },
            flip: function(facing){
                console.log("Facing front: " + facing);
                onFlip(facing);
            }
        });
    }

    function closeNewHouse(){
        $("#newHouse").removeClass("open");
        $("body").removeClass("locked");
    }

    function openNewHouse() {
        $("#newHouse").addClass("open");
        $("body").addClass("locked");
    }

    function showImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.querySelector('#houseImage').src =  e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // $("html").on("dragover", function(event) {
    //     event.preventDefault();  
    //     event.stopPropagation();
    //     $(this).addClass('dragging');
    // });

    // $("html").on("dragleave", function(event) {
    //     event.preventDefault();  
    //     event.stopPropagation();
    //     $(this).removeClass('dragging');
    // });

    // $("html").on("drop", function(event) {
    //     event.preventDefault();  
    //     event.stopPropagation();
    //     alert("Dropped!");
    // });

    function saveHouse(){
        showLoading();
//        document.getElementById('createHouseForm').submit();
    }
</script>