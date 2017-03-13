<a href="user/{{$user->id}}" style="display: block; position:absolute;z-index: 999999;top: -150px;left: calc(50% - 140px); background-color: #ddd; color: inherit; width: 280px;">
<?php
	$followed_str = $followed ? "followed" : "follow";
	$is_followed = $followed;
?>
<style>
	#profilePopup{
		position: relative;
		background-color: #ddd;
		background-image: -webkit-linear-gradient(#ddd, #fefefe);
		background-image: -o-linear-gradient(#ddd, #fefefe);
		background-image: linear-gradient(#ddd, #fefefe);
		border-radius: 4px;
		text-align: center;
		padding-top: 120px;
	}
	#userDetails{
		position: relative;
		z-index: 1;
		padding-bottom: 10px;
		padding-top: 25px;
		z-index: 3;
		background-color: #ddd;/* white;*/
		/*border: 2px solid #ddd;*/
	}
	#profilePopup:before{
		content: "";
		width: 100%;
		height: 120px;
		position: absolute;
		top: 0;
		left:0;
		background-color: rgba(0,0,0,0.7);
		z-index: 2;
	}
	#profilePopup:after{
		content: "";
		width: 80px;
		height: 80px;
		position: absolute;
		bottom: -8px;
		left:calc(50% - 42.5px);
		border-radius: 3px;
		background-color: #ddd;/* white;*/
		/*border: 2px solid #ddd;*/
		-webkit-transform: rotate(45deg);
		-ms-transform: rotate(45deg);
		-o-transform: rotate(45deg);
		transform: rotate(45deg);
	}
	#profilePopup > #cover{
		position: absolute;
		top: 0; left: 0;
		height: 120px;
		width: 100%;
		background-position: center;
		background-size: cover;
	}
	#profilePopup #profilePic{
		margin: auto;
		width: 90px;
		height: 90px;
		border-radius: 50%;
		overflow: hidden;
		background-position: center;
		background-size: cover;
		margin-top: -100px;
		position: relative;
	}
	#profilePopup #username{
		display: inline-block;
		font-size: 20px;
		font-family: georgia;
		margin: 4px 0;
	}
	#profilePopup button{
		background: transparent;
		border: none;
		font-weight: bold;
		/*margin-top: -20px;*/
		display: none;
	}
	.lg-followed, {background-color: #ffa500;}
	.lg-followed:hover, .lg-followed:focus{background-color: rgba(0,0,0,0.4);}

	#followBtnLg span{
		text-transform: uppercase;
	}
	#followBtnLg:not(.lg-followed) span:nth-child(2){
		display: none;
	}

	#followBtnLg.lg-followed span:nth-child(1){
		display: none;
	}
	
	#profilePopup ul{
		list-style: none;
		height: 75px;
		padding: 0 12px;
		margin: 0;
		margin-top: -0.15em;
		/*padding-bottom: 30px;*/
	}
	#profilePopup ul li{
		text-align: center;
		float: left;
		padding: 3px;
		width: calc(33.333% - 10px);
	}
	#profilePopup ul li span{
		display: block;
		margin: 3px 0;
		text-align: center;
		font-weight: bold;
		font-size: 19px;
	}
	#profilePopup ul li span:nth-child(2){
		font-weight: normal;
		font-size: 14px;
	}
</style>

<div id="profilePopup">
	<div id="cover" style="background-image: url({{asset($user->cover($house_url, $user_url))}});"></div>

	<div id="userDetails" class="text-center">
		<div id="profilePic" style="background-image: url({{asset($user_url . $user->dp)}});">
			
		</div>

		<span id="username">{{$user->full_name()}}</span>

		@if(!$myProfile)
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

		<ul>
			<li><span>{{$user->projects_count}}</span><span>PROJECTS</span></li>
			<li><span>{{$user->houses_count}}</span><span>HOUSES</span></li>
			<li><span>{{$user->followers_count}}</span><span>FOLLOWERS</span></li>
		</ul>
	</div>
</div>

<script>
	var is_followed = <?php echo $is_followed ? 0 : 1 ?>;
	var followers_count = <?php echo $user->followers_count; ?>;

	function followUser(url){
        var formdata = new FormData($("#followUser")[0]);

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
</script>
</div>