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
        padding: 32px 36px;
        padding-top: 8px;border-radius: 6px;
        width: 500px;
        max-height: 400px;
        overflow: hidden;
        overflow-y: auto;
    }

    @media only screen and (max-width: 760px) {
        #newShopOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
            max-height: calc(100vh - 20px) !important;
            padding-bottom: 20px !important;
        }
    }
</style>
<div id="newShopOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewShop()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Shop</h5>

            <button disabled onclick="addNewShop()" class="btn save-new-shop" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewShop()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newShop" enctype="multipart/form-data" method="POST" action="/createShop" onsubmit="addNewShop(event)">
                <h3 class="hidden-xs">New Shop</h3>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                {{csrf_field()}}

                <label>Image</label>
                <input type="file" name="image_url" id="newShopImage" style="margin-bottom: 40px;">

                <label>Name</label>
                <input autocomplete="off" id="newShopTitle" name="name" type="text" placeholder="eg. Furniture za kisasa" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Type</label>
                <input autocomplete="off" id="newShopPrice" name="type" type="text" placeholder="Shop type " required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Street:</label>
                <input autocomplete="off" name="street" type="text" placeholder="Street " style="font-size: 1.5em; margin-bottom: 40px;">

                <label>Town:</label>
                <input autocomplete="off" name="town" type="text" placeholder="Town " style="font-size: 1.5em; margin-bottom: 40px;">

                <label>City/Region:</label>
                <input autocomplete="off" name="city" type="text" placeholder="City/Region " style="font-size: 1.5em; margin-bottom: 40px;">

                <label>Country:</label>
                <input autocomplete="off" name="country" type="text" placeholder="Country " style="font-size: 1.5em; margin-bottom: 40px;">

                <label>Quality Slogan Statement</label>
                <textarea id="newShopDesc" placeholder="Shop Quality Slogan" name="quality_statement" cols="10" rows="3" required onkeyup="setSubmit()"></textarea>

                <label>Service Slogan Statement</label>
                <textarea id="newShopTypee" placeholder="Shop Service Slogan" name="service_statement" cols="10" rows="3" required onkeyup="setSubmit()"></textarea>

                <button disabled class="btn btn-primary save-new-shop hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="submit">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a shop</p>
        @endif
    </div>
</div>

<script>
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
        if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newShopTitle").val();
        setSubmit("");

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
                if(response.success){
                    console.log("Success! from new shop, ", response);
                    closeNewShop();
                    showLoading();
                    window.location.href = base_url + "/shop/" + response.shop.id;
                }else{
                    console.log("Success! not", response);
                    $('.save-new-shop').removeAttr("disabled");
                    showToast("error", response.msg);
                }
            })
            .fail(function(response){
                console.log("Error!, ", response);
                $('.save-new-shop').removeAttr("disabled");
                showToast("error", "Unknown Error occured");
            })
            .always(function(){
                console.log("Action done");
                hideLoading();
            });
    }

    function setSubmit(){
        var title = $("#newShopTitle").val();
        var price = $("#newShopPrice").val();
        var description = $("#newShopDesc").val();
        var shop_type = $("#newShopTypee").val();

        if(title.length > 0
                && price.length > 0
                && description.length > 0
                && shop_type.length > 0){
            $('.save-new-shop').removeAttr("disabled");
        }else{
            $('.save-new-shop').attr("disabled", "disabled");
        }
    }
</script>