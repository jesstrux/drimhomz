<?php
if(!Auth::guest()){
	$user = Auth::user();
}
?>
<style>
    #newPictureOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newPictureOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
    }

    #dpOuter:not(.saving) .layout{
        opacity: 0 !important;
        pointer-events: none !important;
    }

    @media only screen and (max-width: 760px) {
        #newPictureOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
    }
</style>
<div id="newPictureOuter" class="cust-modal">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewPicture()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Profile Picture</h5>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative; text-align: center;">
        <div id="dpOuter" style="position: relative; margin-top: 20px; display: inline-block; border-radius: 50%; overflow: hidden;">
            <img src="{{$user_url . $user->dp}}" alt="{{$user->fname}}'s picture" id="temp-dp" style="width: 200px; height: 200px; border-radius: 50%; background-color: #ddd">

            <div class="layout center-center" style="background-color: rgba(5,5,5,0.5); position: absolute; top: 0; left: 0;width: 100%; height: 100%;">
                <img src="{{asset("images/loading.gif")}}" alt="loading..." style="width: 60px;">
            </div>
        </div>

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewPicture()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newPicture" enctype="multipart/form-data" role="form" method="POST" action="{{ url('save-dp') }}" onsubmit="savePicture(event, false)">
                <h3 class="hidden-xs">New profile picture</h3>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="file" id="filePicker" name="dp" class="hidden" onchange="fileChosen()">
                {{csrf_field()}}
            </form>

            <label for="filePicker" class="btn btn-primary" style="margin: 15px 0; margin-top: 36px; display: inline-block; width: auto; min-width: 250px; font-size: 20px;">CHOOSE PICTURE</label>

            @if($user->dp != null && $user->dp != "def.png")
                <form id="removePicture" method="POST" action="{{ url('save-dp') }}" onsubmit="savePicture(event, true)">
                    <h3 class="hidden-xs">New project</h3>
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    {{csrf_field()}}
                        <button class="btn btn-danger save-new-project" style="margin: 8px 0; display: inline-block; width: auto; min-width: 250px; font-size: 20px;" type="submit">REMOVE PICTURE</button>
                </form>
            @endif
        @endif
    </div>
</div>

<script>
    var org_pic, tempImage;
    function closeNewPicture() {
        $("#newPictureOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newPictureTitle").val("");
    }

    function openNewPicture(e) {
        $("#newPictureOuter").addClass("open");
        $("#newPictureTitle").focus();
        $("body").addClass("locked");

        var previewCard = $("#temp-dp").get(0);
        var previewBox = previewCard.getBoundingClientRect();
        var el = e.currentTarget;
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

        var animation = previewCard.animate([
            {opacity: 0, transform: translate + "scale(0)"},
            {opacity: 1.0, transform: "none"}
        ], {
            duration: 170
        });
    }

    function fileChosen(files){
        if(event.target.files.length){
            var file = event.target.files[0];

            if(file.type.match(/image.*/)) {
                console.log('An image has been loaded');
                var reader = new FileReader();
                reader.onload = function (readerEvent) {
                    tempImage = readerEvent.target.result;
                    $("#temp-dp").attr('src', tempImage);

                    savePicture();
                };
                reader.readAsDataURL(file);
            }
            else{
                showToast("error", "Please choose an image!");
            }
        }
    }

    function savePicture(e, remove){
        if(e){
            e.preventDefault();
        }

        if(!remove){
            var form = $("#newPicture")[0];
        }else{
            var form =  $("#removePicture")[0];
            tempImage = user_base_url + "def.png";
            $("#temp-dp").attr('src', tempImage);
        }

        $("#dpOuter").addClass("saving");
//        return;

        $.ajax({
            type:'POST',
            url: "/saveDp",
            data:new FormData(form),
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
        })
        .fail(function(response){
            console.log("Response!, ", response);
            if(response.responseText == "success"){
                showToast("success", "Successfully saved");
            }
            else{
                console.log("Error occured!", response);
                showToast("error", "An error occured");
            }
        })
        .always(function(){
            console.log("Action done");
            $("#dpOuter").removeClass("saving");
        });
    }
</script>