
@if($myProfile)
	<a href="javascript:void(0);" class="new-button" onclick="openNewProject()">
        <div class="image layout center-center" style="background: #eee; height: 140px">
            <svg fill="#555" height="90" viewBox="0 0 24 24" width="100" xmlns="http://www.w3.org/2000/svg">
			    <path d="M0 0h24v24H0z" fill="none"/>
			    <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
			</svg>
        </div>
        <div style="height: 30px;">
        	<h3 style="font-size: 1.5em; margin: 0; text-align: center;line-height: 40px">New Project</h3>
        </div>
    </a>
@else
	@if(is_null($project_count))
		<div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
			{{$user->fname}} hasn't added any dreams yet.
		</div>
	@endif
@endif

@foreach($projects as $project)
    <?php
        $house_count = $project->houses()->count();
        $trailingS = $house_count == 1 ? "" : "s";
        $houses_text = $house_count > 0 ? $project->houses()->count() : "No";
        $houses_text .= " house" . $trailingS;
    ?>

    <a href="{{url('/project/').'/'.$project->id}}" class="house-card">
        <div class="image" style="pointer-events: auto;">
            {!! $project->cover() !!}
        </div>
        <div class="content">
            <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">{{$project->title}}</h3>
        </div>
    </a>
@endforeach

<div id="newProject" class="cust-modal">
    <button class="closer" onclick="closeNewProject()">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>

    <form id="newProject" class="cust-modal-content" method="POST" action="/createProject">
        <h3>New project</h3>
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$user->id}}">

        <label>Project title</label>
        <input name="title" type="text" placeholder="enter project title here" required>
        <button type="submit" onclic="addNewProject('/createProject')">CREATE</button>
    </form>
</div>

<script>
    function closeNewProject() {
        $("#newProject").removeClass("open");
        $("body").removeClass("locked");
    }

    function openNewProject() {
        $("#newProject").addClass("open");
        $("body").addClass("locked");
    }

    function addNewProject(url){
        var formdata = new FormData($("#newProject")[0]);
        $.ajax({
              type:'POST',
              url: url,
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
                closeNewProject();
                infoSaved("Project created!");
            }
        })
        .fail(function(response){
            console.log("Error!, ", response);
            document.write(response.responseText);
        })
        .always(function(){
            console.log("Action done");
        });
    }
</script>