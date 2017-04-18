<?php
if(!Auth::guest()){
    $user = Auth::user();
}
?>
<style>
    #addRoomsOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #addRoomsOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 0;
        padding-top: 8px;border-radius: 6px;
        width: 400px;
    }

    #newRooms{
        background-color: #f5f5f5;
    }

    #newRooms:not(.loading-content) .the-loader{
        display: none;
    }

    #newRooms > input{
        display: none;
    }

    #newRooms label{
        position: relative;
        padding: 12px 20px;
        color: #333;
    }

    #newRooms.loading-content label{
        display: none;
    }

    #newRooms input:checked + label{
        background-color: #e7e7e7;
        color: #333;
    }

    #newRooms input:checked + label svg:nth-child(1){
        display: none;
    }

    #newRooms input:not(:checked) + label svg:nth-child(2){
        display: none;
    }

    #newRooms label .value-div{
        position: absolute;
        top:0; right:4px;
        bottom: 0;
        padding: 0 4px;
        width: 50px;
        background: inherit;
    }

    #newRooms label .value-div input{
        top:0;
        bottom: 0;
        margin: auto;
        width: 40px;
        background-color: transparent;
        border: none;
        border-bottom: 2px solid #333;
        outline: none;
        text-align: center;
        color: #333;
    }

    #newRooms input:not(:checked) + label .value-div,
    #newRooms input:checked + label:not(.type-room) .value-div{
        display: none;
    }

    @media all and (min-width: 761px) {
        #newRooms{
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 2px 0;
        }
        #addRoomsOuter .cust-modal-content{
            padding-bottom: 10px;
        }
    }

    @media only screen and (max-width: 760px) {
        #addRoomsOuter .cust-modal-content{
            padding-top: 12px;
            border-radius: 0;
            height: 100vh;
            overflow-y: auto;
            background-color: #f5f5f5 !important;
        }
    }
</style>
<div id="addRoomsOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeAddRooms()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Add Rooms</h5>

            <button disabled onclick="saveRooms()" class="btn save-new-rooms" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeAddRooms()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="addRooms" method="POST" action="{{$add_rooms_url}}" onsubmit="saveRooms(event)">
                <h3 class="hidden-xs" style="margin-left: 26px;">Add Rooms</h3>
                <input id="homeIdInput" type="hidden" name="home_id" value="{{$real->id}}">
                {{csrf_field()}}

                <div id="newRooms">
                    <div class="the-loader"  style="margin: 20px 0; text-align: center; height: 40px;">
                        <img src="{{asset('images/loading.gif')}}" alt="loading-content" height="100%">
                    </div>
                </div>

                <button disabled class="btn btn-primary save-new-rooms hidden-xs" style="float: right; margin-right: 20px; margin-bottom: 10px;" id="newProjectBtn" type="submit" onclic="saveRooms()">&nbsp;SAVE&nbsp;</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to add rooms</p>
        @endif
    </div>
</div>

<script>
    var chosen_count = 0;

    $(document).ready(function(){
//        openAddRooms();

        $(document).on("change", "#newRooms input[type='checkbox']", function(){
            chosen_count = $("#newRooms input[type='checkbox']:checked").length;
            if(chosen_count > 0)
                $(".save-new-rooms").removeAttr("disabled");
            else
                $(".save-new-rooms").attr("disabled", "disabled");
        });
    });

    function closeAddRooms() {
        $("#addRoomsOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newRooms label, #newRooms input").remove();
        chosen_count = 0;
        $(".save-new-rooms").attr("disabled", "disabled");
    }

    function openAddRooms() {
        var homeId = $("#homeIdInput").val();
        var url = "/missingUtilities/"+homeId+"/"+"<?php echo $utilities?>";

        $("#addRoomsOuter").addClass("open");
        var newRooms = $("#newRooms");
        newRooms.addClass("loading-content");

        $.get(url, function(res){
            if(res.length < 1)
                newRooms.append($("<p>No new rooms available.</p>"));

            for(var i = 0; i < res.length; i++){
                var room = res[i];
                var room_count = '<div class="value-div layout center-center"><input autocomplete="off" name="count'+room.id+'" type="text" value="1"></div>';

                var checkbox_html = "<input id='aroom"+room.id+"' name='utility_id[]' value='"+room.id+"' type='checkbox'>";
                var label_html = '<label for="aroom'+room.id+'" class="type-'+room.type+'"><div class="layout"><svg fill="#333" xmlns="http://www.w3.org/2000/svg" style="widt: 24px;min-width: 24px; margin-right: 8px;" width="24" height="24" viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg> <svg fill="#333" xmlns="http://www.w3.org/2000/svg" style="widt: 24px;min-width: 24px; margin-right: 8px;" width="24" height="24" viewBox="0 0 24 24"><path d="M19 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.11 0 2-.9 2-2V5c0-1.1-.89-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg><span class="flex layout center">'+room.name+'</span></div>'+room_count+'</label>';
                newRooms.append($(checkbox_html));
                newRooms.append($(label_html));
            }

            newRooms.removeClass("loading-content");
        });

        $("body").addClass("locked");
    }

    function saveRooms(e){
        if(e){
            e.preventDefault();
        }

        showLoading();

        if(chosen_count < 1)
            showToast("error", "Please choose atleast one room!");
        var add_room_form = $("#addRooms");
        var formdata = new FormData(add_room_form[0]);

        $.ajax({
            type:'POST',
            url: add_room_form.attr("action"),
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                console.log("Success! from new project, ", response);

                var rooms_list = $(".rooms-list");
                if(rooms_list.hasClass("no-content"))
                    rooms_list.removeClass("no-content");

                for(var i = 0; i < response.rooms.length; i++){
                    var room = response.rooms[i];
                    var room_count = "";
                    if(room.type == "room")
                        room_count = '<span class="room-count">'+response.counts[i]+'</span>';

                    var room_html = '<span id="room'+room.id+'" class="room-item layout inline">'+room_count + room.name+' <form id="removeRoom'+room.id+'" action="<?php echo $remove_room_url ?>" onsubmit="removeRoom(event, '+room.id+')" method="post"> '+_token+' <input type="hidden" name="home_utility_id" value="'+room.id+'"><button type="submit" class="room-remover layout center-center"><svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg></button></form></span>';

                    rooms_list.find(".the-list").append($(room_html));

                    console.log($(room_html));
                }

                closeAddRooms();
                showToast("success", response.msg);
            }else{
                console.log("Success! not", response);
                $('.save-new-rooms').removeAttr("disabled");
                showToast("error", response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            $('.save-new-rooms').removeAttr("disabled");
            showToast("error", "Unknown Error occured");
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }

    function removeRoom(e, id){
        e.preventDefault();

        showLoading();

        var remove_room_form = $("#removeRoom"+id);
        var formdata = new FormData(remove_room_form[0]);

        $.ajax({
            type:'POST',
            url: remove_room_form.attr("action"),
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            if(response.success){
                $(".rooms-list").find("#room"+id).remove();
                showToast("success", "Room removed");
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
</script>