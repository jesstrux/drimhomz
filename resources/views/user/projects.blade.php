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
        #createHouse{
            height: 140px !important;
        }
        #newProjectOuter .cust-modal-content{
            padding-top: 22px;
            border-radius: 0;
        }
    }
</style>
@if($myProfile)
	<a id="createProjectBtn" href="javascript:void(0);" class="new-button" onclick="openNewProject()">
        <div id="createHouse" class="image layout center-center" style="background: #eee; height: 200px">
            <svg fill="#777" height="120" viewBox="0 0 24 24" width="120" xmlns="http://www.w3.org/2000/svg">
			    <path d="M0 0h24v24H0z" fill="none"/>
			    <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
			</svg>
        </div>
        <div style="margin-to: 5px;">
        	<h3 style="font-size: 1.3em; margin: 0; padding: 12px 0;text-align: center;height: 40px; line-height: 30px">New Project</h3>
        </div>
    </a>
@else
	@if(is_null($project_count))
		<div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
			{{$user->fname}} hasn't added any houses yet.
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

@include('project.new-project')

<script>
    function projectCreationSuccess(project){
        console.log("Mpaka hapa");
        window.location.href = base_url + "/editProject/" + project.id;
        showToast("success", "Project created!");

        var proj_html = `<a href="/project/`+project.id+`" class="house-card">
            <div class="image" style="pointer-events: auto;">
                `+project.cover+`
            </div>
            <div class="content">
                <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">`+project.title+`</h3>
            </div>
        </a>`;

        var new_project = $(proj_html);
        $("#createProjectBtn").after(new_project);
    }

    function projectCreationError(msg){
        var message = msg && msg.length ? msg : "Couldn't create project!";
        showToast("error", message);
    }
</script>