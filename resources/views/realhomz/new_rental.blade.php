<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #newRentalOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newRentalOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 32px 36px;
        padding-top: 8px;border-radius: 6px;
        width: 500px;
    }

    @media only screen and (max-width: 760px) {
        #newRentalOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
    }
</style>
<div id="newRentalOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewRental()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Rental</h5>

            <button disabled onclick="addNewRental()" class="btn save-new-rental" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewRental()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newRental" method="POST" action="/createRental" onsubmit="addNewRental(event)">
                <h3 class="hidden-xs">New Rental</h3>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{csrf_field()}}
                <label>Title</label>
                <input autocomplete="off" id="newRentalTitle" name="name" type="text" placeholder="eg. Bungalow in Kyela" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Price</label>
                <input autocomplete="off" id="newRentalPrice" name="price" type="number" placeholder="price of the rental" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="setSubmit()">

                <label>Description</label>
                <textarea id="newRentalDesc" placeholder="Short description about rental" name="description" cols="10" rows="5" required onkeyup="setSubmit()"></textarea>

                <button disabled class="btn btn-primary save-new-rental hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="button" onclick="addNewRental()">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a rental</p>
        @endif
    </div>
</div>

<script>
    function closeNewRental() {
        $("#newRentalOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newRentalTitle").val("");
    }

    function openNewRental() {
        $("#newRentalOuter").addClass("open");
        $("#newRentalTitle").focus();
        $("body").addClass("locked");
    }

    function addNewRental(e){
        if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newRentalTitle").val();
        setSubmit("");

        var formdata = new FormData($("#newRental")[0]);
        // formdata.append("_token", $(_token).val());

        $.ajax({
                    type:'POST',
                    url: "/createRental",
                    data: formdata,
                    dataType:'json',
                    async:false,
                    processData: false,
                    contentType: false
                })
                .done(function(response){
                    if(response.success){
                        console.log("Success! from new rental, ", response);
                        closeNewRental();
                        showLoading();
                        window.location.href = base_url + "/realhomz/rentals/" + response.rental.id + "/new";
                    }else{
                        console.log("Success! not", response);
                        $('.save-new-rental').removeAttr("disabled");
                        showToast(response.msg);
                    }
                })
                .fail(function(response){
                    console.log("Error!, ", response);
                    $('.save-new-rental').removeAttr("disabled");
                    showToast("Unknown Error occured");
                })
                .always(function(){
                    console.log("Action done");
                    hideLoading();
                });
    }

    function setSubmit(){
        var title = $("#newRentalTitle").val();
        var price = $("#newRentalPrice").val();
        var description = $("#newRentalDesc").val();

        if(title.length > 0 && price.length > 0 && description.length > 0){
            $('.save-new-rental').removeAttr("disabled");
        }else{
            $('.save-new-rental').attr("disabled", "disabled");
        }
    }
</script>