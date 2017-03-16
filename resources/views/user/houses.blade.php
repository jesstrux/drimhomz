@if($myProfile)
    <a href="javascript:void(0);" class="new-button" onclick="openNewHouse()">
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
@elseif(!$myProfile && is_null($house_count))
	<div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
		{{$user->fname}} hasn't added any houses yet.
	</div>
@endif


@foreach($houses as $house)
    <?php
        $fav_count = $house->favorites->count();
        $trailingS = $fav_count == 1 ? "" : "s";
        $likes_text = $fav_count. " like".$trailingS;

        $comment_count = $house->comments->count();
        $trailingS = $comment_count == 1 ? "" : "s";
        $comments_text = $comment_count. " comment".$trailingS;
    ?>
    <div style="cursor: pointer;" class="house-card a-house-item" data-house="{{$house}}" data-user="{{$user}}" data-comments="{{$comment_count}}" data-favs="{{$fav_count}}">
        <div class="image" style="background-color: {{$house->placeholder_color}}">
            <img src="{{asset($house_url . $house->image_url)}}" alt="{{$house->title}}">
        </div>
        <div class="content">
            <h3>{{$house->title}}</h3>
            <span class="social-stuff">
            	{{$likes_text}} <span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}
            </span>
        </div>
    </div>
@endforeach


<div id="newHouse" class="cust-modal">
    <button class="closer" onclick="closeNewHouse()">
        <svg fill="#ddd" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
    </button>

    <form enctype="multipart/form-data" class="cust-modal-content" method="POST" action="/createHouse" style="width: 380px; padding-top: 15px;">
        <h3>New House</h3>
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$user->id}}">

        <label style="margin-bottom: 8px;">Pick an image</label>
        <input style="margin-bottom: 10px;" name="image_url" type="file" required><br>

        @if(!is_null($project_count))
            <label>Select a project</label>
            <select name="project_id" required>
                <option value="">Choose an option</option>

                @foreach($projects as $project)
                    <option value="{{$project->id}}">
                        {{$project->title}}
                    </option>
                @endforeach
            </select>
        @else
            <label>Project title</label>
            <input type="text" name="project_title" required>
        @endif

        <label>Title</label>
        <input name="title" type="text" placeholder="enter project title here" required>

        <button type="submit">CREATE</button>
    </form>
</div>

<script>
    function closeNewHouse(){
        $("#newHouse").removeClass("open");
        $("body").removeClass("locked");
    }

    function openNewHouse() {
        $("#newHouse").addClass("open");
        $("body").addClass("locked");
    }
</script>