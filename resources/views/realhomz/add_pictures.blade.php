<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #addPicturesOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }

    #addPicturesOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 0;
        padding-top: 8px;border-radius: 6px;
        width: 400px;
        padding-bottom: 9px;
    }

    #newPicturesGrid{
        background-color: #eee;
        min-height: 300px;
        max-height: 350px;
        margin-bottom: 20px;
        overflow: hidden;
        overflow-y: auto;
        position: relative;
    }

    #newPicturesGrid img{
        align-self: flex-start;
        /*width: 100%;*/
        width: calc(33.333% - 8px);
        background-color: #ddd;
        margin: 4px;
    }


    #newPicturesGrid .no-images{
        position: absolute;
        width: 100%;
        height: 100%;
    }

    #newPicturesGrid .no-images label{
        width: auto;
        background-color: #d5d5d5;
        color: #333;
    }

    #newPicturesGrid.images-set .no-images{
        display: none;
    }

    #newPicturesGrid:not(.images-set) #theImages{
        display: none;
    }

    #chooserFab{
        display: -ms-flexbox !important;
        display: -webkit-flex !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 50%;
        border: none;
        box-shadow: 1px 1px 8px rgba(0,0,0,0.2);
        background-color: #aaa;
        position: absolute;
        bottom: 53px;
        left: 25px;
        cursor: pointer;
    }

    #newPicturesGrid:not(.images-set) ~ #chooserFab{
        display: none !important;
    }

    .a-fab.invisible{
        opacity: 0;
        pointer-events: none;
    }

    @media only screen and (max-width: 760px) {
        #addPicturesOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
        #newPicturesGrid{
            background-color: #eee;
            height: 100vh;
            margin-bottom: 20px;
        }

        #newPicturesGrid img{
            width: 50%;
        }
    }
</style>
<div id="addPicturesOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeAddPictures()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Add Pictures</h5>

            <button disabled onclick="savePictures()" class="btn save-pictures-btn" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeAddPictures()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <h3 style="margin-left: 26px; margin-bottom: 13px;" class="hidden-xs">Add Pictures</h3>

            <div id="newPicturesGrid">
                <div class="no-images layout vertical center-center">
                    <p style="font-size: 1.23em; margin-bottom: 20px;">No pictures chosen</p>
                    <label class="btn" for="images_chooser">
                        CHOOSE PICTURES
                    </label>
                </div>

                <div class="layout wrap" id="theImages" style="position: absolute; height: 100%; width: 100%;">
                </div>
            </div>

            <label id="chooserFab" for="images_chooser">
                <svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            </label>

            <form id="addPictures" method="POST" action="{{$add_pictures_url}}" onsubmit="savePictures(event)" enctype="multipart/form-data">
                <input type="hidden" name="home_id" value="{{$real->id}}">
                <input style="display: none" id="images_chooser" type="file" name="house_images[]" multiple accept="image/*" onchange="previewImages(this)">
                {{csrf_field()}}

                <button disabled class="btn btn-primary save-pictures-btn hidden-xs" style="float: right; margin-right: 20px; margin-bottom: 10px;" id="newProjectBtn" type="submit">&nbsp;SAVE&nbsp;</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to add pictures</p>
        @endif
    </div>
</div>

<script src="{{asset('js/wookmark.min.js')}}"></script>
<script>
    function closeAddPictures() {
        $("#addPicturesOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#theImages").html("");
        $("#newPicturesGrid").removeClass("images-set");
        $("#addPicturesBtn").removeClass("invisible");
        $(".save-pictures-btn").attr("disbaled", "disbaled");

        var control = $("#images_chooser");
        control.replaceWith( control = control.clone( true ) );
    }

    function openAddPictures() {
        $("#addPicturesOuter").addClass("open");
        $("body").addClass("locked");
        $("#addPicturesBtn").addClass("invisible");
    }

    function savePictures(e){
        if(e){
            e.preventDefault();
        }

        showLoading();
        var add_pictures_form = $("#addPictures");
        var formdata = new FormData(add_pictures_form[0]);

        $.ajax({
            type:'POST',
            url: add_pictures_form.attr("action"),
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                closeAddPictures();
                showToast("success", response.msg);
            }else{
                showToast("error", response.msg);
            }
        })
        .fail(function(response){
            showToast("error", "Unknown Error occured");
        })
        .always(function(){
            hideLoading();
        });
    }

    function previewImages(input) {
        var loaded_files = 0;
        var files_count = input.files.length;
        $("#theImages").html("");
        if (input.files && files_count) {
            $("#newPicturesGrid").addClass("images-set");

            $('.save-pictures-btn').removeAttr("disabled");
            for(var i = 0; i < files_count; i++){
                if(input.files[i]){
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        loaded_files++;
                        var img = $('<img src="'+e.target.result+'"/>');
                        $("#theImages").append(img);
                    };

                    reader.readAsDataURL(input.files[i]);
                }
            }

            var images_interval = setInterval(function(){
                if(loaded_files == files_count){
                    arrangeImages();
                    clearInterval(images_interval);
                }
            }, 30);
        }else{
            $("#newPicturesGrid").removeClass("images-set");
            $('.save-pictures-btn').attr("disabled", "disabled");
        }
    }

    function arrangeImages(){
        wookmark = new Wookmark("#theImages", {
            offset: 8,
            align: 'left'
        });

        wookmark.initItems();
        wookmark.layout(true);
    }
</script>