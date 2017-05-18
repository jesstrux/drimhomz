<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #newProductOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newProductOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 32px 36px;
        padding-top: 8px;border-radius: 6px;
        width: 500px;
        max-height: 400px;
        overflow: hidden;
        overflow-y: auto;
    }

    @media only screen and (max-width: 760px) {
        #newProductOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
            max-height: calc(100vh - 20px) !important;
            padding-bottom: 20px !important;
        }
    }
</style>
<div id="newProductOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewProduct()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Product</h5>

            <button disabled onclick="addNewProduct()" class="btn save-new-product" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewProduct()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newProduct" enctype="multipart/form-data" method="POST" action="/createProduct" onsubmit="addNewProduct(event)">
                <h3 class="hidden-xs">New Product</h3>
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <input type="hidden" name="shop_id" value="{{$shop->id}}">
                {{csrf_field()}}

                <label>Image</label>
                <input type="file" name="image_url" id="newProductImage" style="margin-bottom: 40px;">

                <label>Name</label>
                <input autocomplete="off" id="newProductTitle" name="name" type="text" placeholder="eg. Mbao za mninga" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Price</label>
                <input autocomplete="off" id="newProductPrice" name="price" type="number" placeholder="price of the product" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Brand(Optional):</label>
                <input autocomplete="off" name="brand" type="brand" placeholder="brand of the product"  style="font-size: 1.5em; margin-bottom: 40px;">

                <label>Description</label>
                <textarea id="newProductDesc" placeholder="Short description about product" name="description" cols="10" rows="3" required onkeyup="setSubmit()"></textarea>

                <label>Specification</label>
                <textarea id="newProductTypee" placeholder="Product specification" name="specification" cols="10" rows="3" required onkeyup="setSubmit()"></textarea>

                <button disabled class="btn btn-primary save-new-product hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="submit">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a product</p>
        @endif
    </div>
</div>

<script>
    function closeNewProduct() {
        $("#newProduct").find("input, select, textarea").each(function(){
            $(this).val("");
        });

        $("#newProductOuter").removeClass("open");
        $("body").removeClass("locked");
    }

    function openNewProduct() {
        $("#newProductOuter").addClass("open");
        $("#newProductTitle").focus();
        $("body").addClass("locked");
    }

    function addNewProduct(e){
        if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newProductTitle").val();
        setSubmit("");

        var formdata = new FormData($("#newProduct")[0]);
        // formdata.append("_token", $(_token).val());

        $.ajax({
            type:'POST',
            url: "/createProduct",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                var product = response.product;

                console.log("Success! from new product, ", response);
                showToast("success", "Product created!");

                var proj_html = '<div style="cursor: pointer;" class="house-card"> <div class="image"> <img src="'+ product_base_url + product.image_url + '"/> </div> <div class="content"> <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">'+product.name+'</h3> </div> </div>';

                var new_project = $(proj_html);
                $("#createProductBtn").after(new_project);

                closeNewProduct();
            }else{
                console.log("Success! not", response);
                $('.save-new-product').removeAttr("disabled");
                showToast("error", response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            $('.save-new-product').removeAttr("disabled");
            showToast("error", "Unknown Error occured");
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }

    function setSubmit(){
        var title = $("#newProductTitle").val();
        var price = $("#newProductPrice").val();
        var description = $("#newProductDesc").val();
        var product_type = $("#newProductTypee").val();

        if(title.length > 0
                && price.length > 0
                && description.length > 0
                && product_type.length > 0){
            $('.save-new-product').removeAttr("disabled");
        }else{
            $('.save-new-product').attr("disabled", "disabled");
        }
    }
</script>