<style>
	.lg-followed{
		background-color: #ffa500; color: #f1eee9;
		/*pointer-events: none;*/
	}
	.lg-followed.lg-followed:hover{
		background-color: #f1a00b;color: #f1eee9; 
	}
	.lg-followed.lg-followed:focus{
		background-color: #f1a00b;color: #f1eee9;
	}
	#followBtnLg span{
		text-transform: uppercase;
	}
	#followBtnLg:not(.lg-followed) span:nth-child(2){
		display: none;
	}

	#followBtnLg.lg-followed span:nth-child(1){
		display: none;
	}
</style>

<div id="profileSummaryLg" class="col-sm-12 col-md-5 col-lg-4">
	<div id="userDetails" class="text-center">
		<h3 style="padding-top: 20px;">{{$project->title}}</h3>
		<p style="margin-top: 10px;">{{$project->houses->count()}} Dreams</p>
		@if($myProject)
			<a href="/setupAccount" class="btn btn-default">
				Edit project
			</a>

			<a href="/setupAccount" class="btn btn-default">
				delete project
			</a>
		@endif
		<!-- <hr> -->
		<em>Owner:</em> 
		<strong>
			<a href="{{url('/user/') . '/' . $project->user->id}}">
				{{$project->user->full_name()}}
			</a>
		</strong>
	</div>
</div>

<div id="profileSummary" class="col-sm-12 col-md-4" style="background: #fff; padding: 50px 25px; text-align: cente;margin-top: -12px; border-bottom: 1px solid #ddd; margin-bottom: 3px;">

	<div class="layout center">
		<div class="layout vertical flex" style="font-size: 2em">
			<span id="name">{{$project->title}}</span>
		</div>
	</div>
	<span id="profession" style="margin-top: 15px; display: block; font-size: 1.2em">
		Owner: <a href="{{url('/user/') . '/' . $project->user->id}}">
			<span id="name">{{$project->user->fname}}</span>
			<span id="name">{{$project->user->lname}}</span>
		</a>
	</span>
</div>

<script>
	function editProject(url){
        var formdata = new FormData($("#editProject")[0]);
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
        })
        .fail(function(response){
            console.log("Response!, ", response);
        })
        .always(function(){
            console.log("Action done");
        });
    }
</script>