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
		<div id="profilePic">
			<img src='{{asset($user_url . $user->dp)}}' 
			alt="{{$user->fname}}'s dp">
		</div>
		<h3>{{$user->full_name()}}</h3>
		
		@if(isset($user->town))
			<p>From {{$user->town}} <br>Vendor</p>
		@else
			<br>
		@endif

		@if($myProfile)
			<a href="{{url('setupAccount')}}" class="btn btn-default">
				Edit profile
			</a>
		@else
			@if(!Auth::guest())
				<form id="followUser" role="form" method="POST" action="{{ url('follow-user') }}">
	                {{ csrf_field() }}
	                <input type="hidden" name="id" value="{{$user->id}}">

	                <button
	                	id="followBtnLg"
	                	type="button"
	                	onclick="followUser('/followUser')"
	                	class="btn btn-default lg-{{$followed_str}}">
	                	<span>follow</span>
	                	<span>followed</span>
	                </button>
	            </form>
	        @endif
		@endif
		<!-- <hr> -->
	</div>
</div>

<div id="profileSummary" class="col-sm-12 col-md-4">
	<div id="lgDp">
		<img src='{{asset($user->dp)}}' 
			alt="{{$user->fname}}'s dp">
		<div id="user">
			<span id="name">{{$user->full_name()}}</span>
			<span id="profession">{{$user->town}}</span>

			@if(!Auth::guest())
				@if($myProfile)
					<form id="editProfile" role="form" 
						method="POST" action="{{ url('edit-profile') }}">
	                
		                {{ csrf_field() }}
		                <input type="hidden" name="id" value="{{$user->id}}">

						<button id="followBtn"
							onclick="editProfile('edit-profile')">
							<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
								<path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
								<path d="M0 0h24v24H0z" fill="none"/>
							</svg>
						</button>
					</form>
				@else
					<button id="followBtn"
						class="{{$followed_str}}"
						onclick="followUser('follow-user')">
						<svg fill="#000000" height="30" viewBox="0 0 24 24" width="30" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"/>
							<path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
						</svg>
					</button>
				@endif
			@endif
		</div>
	</div>
	<div class="tabheads">
		<div class="tabhead">
			<span>{{$project_count}}</span>
			<span>PROJECTS</span>
		</div>
		<div class="tabhead active">
			<span>{{$house_count}}</span>
			<span>HOUSES</span>
		</div>
		<!-- <div class="tabhead">
			<span>{{$following_count}}</span>
			<span>FOLLOWING</span>
		</div> -->

		<div class="tabhead">
			<span class="follower_count">{{$followers_count}}</span>
			<span>FOLLOWERS</span>
		</div>
	</div>
</div>


<script>
	var is_followed = <?php echo $is_followed ?: 0 ?>;
	var followers_count = <?php echo $followers_count ?>;

	function followUser(url){
        var formdata = new FormData($("#followUser")[0]);

        // formdata.forEach( function(element, index) {
        // 	console.log(index, element);
        // });

        // return;

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
            	followers_count += is_followed ? -1 : 1;
            	is_followed = !is_followed;

            	$('.follower_count').text(followers_count);
                $("#followBtnLg").toggleClass('lg-followed');
                $("#followBtn").toggleClass('followed');
            }
        })
        .fail(function(response){
        	document.write(response.responseText);
            console.log("Response!, ", response);
        })
        .always(function(){
            console.log("Action done");
        });
    }

    function editProfile(url){
        var formdata = new FormData($("#editProfile")[0]);
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