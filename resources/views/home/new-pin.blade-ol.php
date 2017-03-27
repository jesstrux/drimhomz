<div id="newPinModal" class="cust-modal">
    <button class="closer hidden-xs hidden-sm" onclick="closeNewPin()">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>

    <div class="hidden visible-xs visible-sm cust-modal-toolbar no-shadow">
        <div class="layout center" style="height: 60px">
            <button class="layout center for-mob" style="padding: 0;background: transparent; border: none;" onclick="closeNewPin()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>

            <h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Choose project</h5>
        </div>
    </div>

    <div class="cust-modal-content">
        <div class="row">
            <div id="toPin" class="col col-md-5 col-xs-12" style="border-right: 1px solid #eee; padding-top: 20px; padding-bottom: 20px; margin-top: 60px;">
                <div id="newPinCard"></div>
            </div>

            <div id="projectList" class="col col-md-7 col-xs-12">
                <div class="hidden" style="position: absolute; height: 100%; width: 100%; background: #fff;box-shadow: -2px 0 1px rgba(0,0,0,0.26); -webkit-transform: translateX(100%);-ms-transform: translateX(100%);-o-transform: translateX(100%);transform: translateX(100%);">
                    <button style="position: absolute; right: 10px; top: 10px">
                        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>

                    <h3>New project</h3>
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$auth_user->id}}">

                    <label>Project title</label>
                    <input name="title" type="text" placeholder="enter project title here" required>
                    <button type="submit" onclic="addnewPin('/createProject')">CREATE</button>
                </div>
                
                <div id="projectItems">
                    <div class="hidden-xs hidden-sm">
                        <h5 style="display: inline-block; font-size: 23px; margin-top: 1px;">Choose project</h5>
                        <button class="cust-modal-button" type="submit" onclic="addnewPin('/createProject')">Create project</button>
                        <hr>
                    </div>

                    <div class="hidden visible-xs visible-sm" style="box-shadow: 0 1px 1px rgba(0,0,0,0.1); background-color: #fff; padding: 8px 12px; padding-top: 12px;">
                        <div class="layout center" style="height: 40px;">
                            <h5 class="flex" style="font-size: 20px; margin: 0;">All projects</h5>

                            <button class="btn btn-info" type="submit" onclic="addnewPin('/createProject')">NEW</button>
                        </div>
                    </div>

                    <div id="projectOptions">
                        <div id="pinAlert" class="alert alert-success alert-dismissible collapse" role="alert">
                          <strong>Success!</strong> <em>Picture saved.</em>
                        </div>

                        @if($user_projects != null)
                            @foreach($user_projects as $proj)
                                <label for="proj{{$loop->iteration}}" style="padding: 12px; background-color: #eee">
                                    <form id="newPin{{$loop->iteration}}" method="POST" action="/createPin" class="layout">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="project_id" id="proj{{$loop->iteration}}" value="{{$proj->id}}">
                                        <div class="flex">
                                            {{$proj->title}}
                                        </div>
                                            
                                        <button class="btn btn-success" type="button" onclick="addnewPin({{$loop->iteration}})">
                                            SAVE
                                        </button>
                                    </form>
                                </label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('project.new-project')
<script>
    function projectCreationSuccess(project){
        showToast("success", "Project created from new pin!");
        var new_it = "new" + project.id;
        var proj_html = `<label for="proj`+new_it+`" style="padding: 12px; background-color: #eee">
            <form id="newPin`+new_it+`" method="POST" action="/createPin" class="layout">
                `+_token+`
                <input type="hidden" name="project_id" id="proj`+new_it+`" value="`+project.id+`">
                <div class="flex">
                    `+project.title+`
                </div>
                    
                <button class="btn btn-success" type="button" onclick="addnewPin(`+new_it+`)">
                    SAVE
                </button>
            </form>
        </label>`;

        var new_project = $(proj_html);
        var first_label = $("#projectOptions label:first");
        if(first_label.length)
            first_label.before(new_project);
        else
            $("#projectOptions").append(new_project);
    }

    function projectCreationError(msg){
        var message = msg && msg.length ? msg : "Couldn't create project!";
        showToast("error", message);
    }

    var pin_id;

    function openNewPinner($jqel, fromPreview) {
        drimMode = true;
        $("#newPinModal").addClass("open");
        console.log("drimMode: " + drimMode);
        $("body").addClass("locked");
        el = $jqel.get(0);
        pin_id = $jqel.attr('data-postid');

        var src = $jqel.find(".image img").attr("src");
        var previewC = $("#newPinCard");
        var previewCard = previewC.get(0);
        var previewBox = previewCard.getBoundingClientRect();
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
        previewCard.style.backgroundPosition = "center";
        previewCard.style.backgroundSize = "cover";
        previewCard.style.backgroundImage = "url("+src+")";
        previewCard.style.opacity = 0;
        
        var animation = previewCard.animate([
            {opacity: 0, transform: translate + "scale(0)"},
            {opacity: 1.0, transform: "none"}
        ], {
            easing: 'ease-in-out',
            duration: fromPreview ? 250 : 150,
            delay: fromPreview ? 20 : 50,
            fill: 'forwards'
        });
    }

    function addnewPin(id){
        var formdata = new FormData($("#newPin"+id)[0]);
        formdata.append("house_id", pin_id);
        formdata.append("user_id", cur_user.id);

        $.ajax({
              type:'POST',
              url: "/pinHouse",
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
                closeNewPin();
                iziToast.success({
                    title: 'Success',
                    message: response.msg,
                    position: 'topRight'
                });
            }else{
                respond("Error", response.msg);
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            // document.write(response.responseText);
            iziToast.error({
                title: 'Error',
                message: 'An unknown error Occured',
                position: 'topRight'
            });
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function closeNewPin() {
        $("#newPinModal").removeClass("open");
        $("body").removeClass("locked");
        drimMode = false;
    }
</script>