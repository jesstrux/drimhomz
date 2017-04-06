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
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
        width: 300px;
    }

    @media only screen and (max-width: 760px) {
        #addPicturesOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
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

            <button disabled onclick="savePictures()" class="btn save-new-project" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeAddPictures()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="addPictures" method="POST" action="/addPictures" onsubmit="savePictures(event)">
                <h3 class="hidden-xs">Add Pictures</h3>
                <input type="hidden" name="home_id" value="{{$real->id}}">
                {{csrf_field()}}

                <button disabled class="btn btn-primary save-new-project hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="button" onclick="savePictures()">SAVE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to add pictures</p>
        @endif
    </div>
</div>

<script>
    function closeAddPictures() {
        $("#addPicturesOuter").removeClass("open");
        $("body").removeClass("locked");
    }

    function openAddPictures() {
        $("#addPicturesOuter").addClass("open");
        $("body").addClass("locked");
    }

    function savePictures(e){
        if(e){
            e.preventDefault();
        }

        showLoading();

        var formdata = new FormData($("#addPictures")[0]);

        $.ajax({
            type:'POST',
            url: "/addPictures",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                console.log("Success! from new project, ", response);
                closeAddPictures();
                showLoading();
            }else{
                console.log("Success! not", response);
                $('.save-new-project').removeAttr("disabled");
                showToast(response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            $('.save-new-project').removeAttr("disabled");
            showToast("Unknown Error occured");
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }
</script>