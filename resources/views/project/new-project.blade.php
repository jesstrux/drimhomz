<?php
    if(!Auth::guest()){
        $user = Auth::user();
    }
?>
<style>
    #newProjectOuter{
        background-image: none;
        background-color: rgba(0,0,0,0.1);
    }
    #newProjectOuter .cust-modal-content{
        box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
        padding: 22px 26px;
        padding-top: 8px;border-radius: 6px;
    }

    @media only screen and (max-width: 760px) {
        #newProjectOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
    }
</style>
<div id="newProjectOuter" class="cust-modal has-trans">
    <div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewProject()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">New Project</h5>

            <button disabled onclick="addNewProject()" class="btn save-new-project" style="background:#8bc34a; border-radius: 5px; overflow: hidden;color: #fff; margin-right: 10px;">
                SAVE
            </button>
        </div>
    </div>

    <div class="cust-modal-content" style="position: relative;">

        @if(isset($user))
            <button class="closer hidden-xs" onclick="closeNewProject()">
                <svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
            </button>

            <form id="newProject" method="POST" action="/createProject" onsubmit="addNewProject(event)">
                <h3 class="hidden-xs">New project</h3>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{csrf_field()}}
                <label>Project title</label>
                <input autocomplete="off" id="newProjectTitle" name="title" type="text" placeholder="eg. Cool houses" required style="font-size: 1.5em; margin-bottom: 40px;" onkeyup="activateSubmit(this.value)">
                <button disabled class="btn btn-primary save-new-project hidden-xs" style="float: right; margin-righ: 8px; margin-bottom: 10px;" id="newProjectBtn" type="button" onclick="addNewProject()">CREATE</button>
            </form>
        @else
            <p>Please <a href="{{url('/login/')}}"><strong>login</strong></a> to create a project</p>
        @endif
    </div>
</div>

<script>
    var curTitle, nitoe_ripoti;

    $("#newProjectTitle").val("");
    function closeNewProject() {
        $("#newProjectOuter").removeClass("open");
        $("body").removeClass("locked");
        $("#newProjectTitle").val("");

        if(nitoe_ripoti)
            newProjectClosed();
    }

    function openNewProject(toaRipoti) {
        $("#newProjectOuter").addClass("open");
        $("#newProjectTitle").focus();
        $("body").addClass("locked");
        if(toaRipoti)
            nitoe_ripoti = toaRipoti;
    }

    function addNewProject(e){
        if(e){
            e.preventDefault();
        }

        showLoading();
        curTitle = $("#newProjectTitle").val();
        activateSubmit("");

        var formdata = new FormData($("#newProject")[0]);
        // formdata.append("_token", $(_token).val());

        $.ajax({
              type:'POST',
              url: "/createProject",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
//            console.log("Response! from new project, ", response);
            if(response.success){
                closeNewProject();
                if(location.href.indexOf("user") !== -1 && !drimMode){
                    showLoading();
                    window.location.href = base_url + "/editProject/" + response.project.id;
                    showToast("success", "Project successfully created");
                }
                else{
                    projectCreationSuccess(response.project);
                }
            }else{
                $("#newProjectTitle").focus();
                $("#newProjectTitle").val(curTitle);
                activateSubmit(curTitle);
                projectCreationError(response.msg);
            }
        })
        .fail(function(response){
            showToast("error", "Unknown error occured");
            console.log("Error!, ", response);
            projectCreationError();
            $("#newProjectTitle").focus();
            $("#newProjectTitle").val(curTitle);
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