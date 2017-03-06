<div id="userProjects" class="tab-pane fade in" style="padding: 0;">
	@if($myProfile)
		<a href="#" class="new-button">
            <div class="image layout center-center" style="background: #eee;">
                <svg fill="#555" height="100" viewBox="0 0 24 24" width="100" xmlns="http://www.w3.org/2000/svg">
				    <path d="M0 0h24v24H0z" fill="none"/>
				    <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
				</svg>
            </div>
            <div style="height: 50px;">
            	<h3 style="font-size: 1.5em; margin: 0; text-align: center;line-height: 70px">New house</h3>
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
            $house_count = count($project->favorites);
            $trailingS = $house_count == 1 ? "" : "s";
            $houses_text = $house_count > 0 ?: "No" . " houses".$trailingS;
        ?>
        <div class="house-card">
            <div class="image">
                <img src="{{asset($house->image_url)}}" alt="modern bath">
            </div>
            <div class="content">
                <h3>{{$project->title}}</h3>
                <span class="social-stuff">
                	{{$likes_text}} <span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}
                </span>
            </div>
        </div>
    @endforeach
</div>