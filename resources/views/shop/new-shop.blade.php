<?php
    if(!Auth::guest()){
        $user = Auth::user();
    }
?>
<style>
    #newShopOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newShopOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
    }

    @media only screen and (max-width: 760px) {
        #newShopOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
    }
</style>
<div id="newShopOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewShop()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Shop</h5>

            <button disabled onclick="addNewShop()" class="btn save-new-project" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewShop()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newShop" method="POST" action="/createShop" onsubmit="addNewShop(event)">
                <h3 class="hidden-xs">New shop</h3>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{csrf_field()}}
                <label>Shop name</label>
                <input autocomplete="off" id="newShopTitle" name="name" type="text" placeholder="eg. Furniture za kisasa" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="activateSubmit(this.value)">
                <button disabled class="btn btn-primary save-new-project hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newShopBtn" type="submit">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a project</p>
        @endif
    </div>
</div>

<script>
    var curTitle;
    $("#newShopTitle").val("");
    function closeNewShop() {
        $("#newShopOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newShopTitle").val("");
    }

    function openNewShop() {
        $("#newShopOuter").addClass("open");
        $("#newShopTitle").focus();
        $("body").addClass("locked");
    }

    function addNewShop(e){
//        return;
        if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newShopTitle").val();
        activateSubmit("");

        var formdata = new FormData($("#newShop")[0]);
        // formdata.append("_token", $(_token).val());

        $.ajax({
              type:'POST',
              url: "/createShop",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
//            console.log("Response! from new project, ", response);
            if(response.success){
                closeNewShop();
                window.location.href = base_url + "/shop/" + response.shop.id;
            }else{
                $("#newShopTitle").focus();
                $("#newShopTitle").val(curTitle);
                activateSubmit(curTitle);
                projectCreationError(response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            projectCreationError();
            $("#newShopTitle").focus();
            $("#newShopTitle").val(curTitle);
            activateSubmit(curTitle);
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }

    function activateSubmit(val){
        if(val.length > 0){
            $('.save-new-project').removeAttr("disabled");
        }else{
            $('.save-new-project').attr("disabled", "disabled");
        }
    }
</script>