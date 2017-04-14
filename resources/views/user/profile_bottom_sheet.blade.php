<div id="profileBottomSheet">

	<style>
		#profileBottomSheet{
			display: block;
			background-color: #fff;
			color: inherit;
			padding: 0;
			position: relative;
			text-align: center;
		}

		#profileBottomSheet #userDetails{
			position: relative;
			z-index: 3;
			/*background-color: #ffa500;*/
			background-color: #F8B530;
			box-shadow: 0 2px 7px rgba(0,0,0,0.2) !important;
		}

		#profileBottomSheet #profilePic{
			margin: auto;
			width: 120px;
			height: 120px;
			border-radius: 50%;
			overflow: auto;
			background-position: center;
			background-size: cover;
			position: relative;
			top: -60px;
			background-color: #d9d9d9;
			box-shadow: 0 0 7px rgba(0,0,0,0.2) !important;

			-webkit-transition: background 0.35s ease-out;
			-moz-transition: background 0.35s ease-out;
			-ms-transition: background 0.35s ease-out;
			-o-transition: background 0.35s ease-out;
			transition: background 0.35s ease-out;
		}

		#profileBottomSheet #username{
			display: block;
			font-size: 2em;
			font-family: georgia, serif;
			margin-top: -50px;
			padding-bottom: 15px;
			color: #fff;
			min-height: 40px;
		}

		#profileBottomSheet button{
			background: transparent;
			border: none;
			font-weight: bold;
			margin-bottom: 15px;
			/*margin-top: 10px;*/
			font-size: 1.5em;
			color: #FEF5E4;
		}

		.lg-followed {background-color: #ffa500;}
		.lg-followed:hover, .lg-followed:focus{background-color: rgba(0,0,0,0.4);}

		#profileBottomSheet #followBtnLg span{
			text-transform: uppercase;
		}

		#profileBottomSheet #followBtnLg:not(.lg-followed) span:nth-child(2){
			display: none;
		}

		#profileBottomSheet #followBtnLg.lg-followed span:nth-child(1){
			display: none;
		}

		#profileBottomSheet ul{
			list-style: none;
			padding: 0;
			margin: 0;
			margin-top: -0.15em;
			/*padding-bottom: 30px;*/
		}

		#profileBottomSheet ul li{
			display: inline-block;
			text-align: center;
			width: 50%;
			min-width: 50%;
			max-width: 50%;
			border-bottom: 1px solid #d5d5d5;
		}

		#profileBottomSheet ul li a{
			display: block;
			/*background-color: #f00;*/
			padding: 20px 0;
			color: inherit;
		}

		#profileBottomSheet ul li:nth-child(odd){
			border-right: 1px solid #d5d5d5;
		}

		#profileBottomSheet ul li span{
			display: block;
			margin: 3px 0;
			text-align: center;
			font-weight: bold;
			font-size: 25px;
		}

		#profileBottomSheet ul li span:nth-child(2){
			font-weight: normal;
			font-size: 19px;
		}
	</style>
	<div id="userDetails" class="text-center">
		<div id="profilePic" style="background-image: url('{{$user_url . 'dp.png'}}');">

		</div>

		<span id="username">&nbsp;</span>

		<form class="hidden" id="followUser" role="form" method="POST" action="{{ url('follow-user') }}">
			{{ csrf_field() }}
			<input type="hidden" name="id">
			<button
					id="followBtnLg"
					type="button"
					onclick="followUser('/followUser')"
					class="btn btn-default">
				<span>follow</span>
				<span>followed</span>
			</button>
		</form>
	</div>

	<ul id="links" class="layout wrap">
		<li>
			<a href="{{url('user/')}}">
				<span id="project_count">0</span><span>PROJECTS</span>
			</a>
		</li>
		<li>
			<a href="{{url('user/')}}">
				<span id="house_count">0</span><span>HOUSES</span>
			</a>
		</li>
		<li>
			<a href="{{url('user/')}}">
				<span id="followers_count">0</span><span>FOLLOWERS</span>
			</a>
		</li>
		<li>
			<a href="{{url('user/')}}">
				<span id="following_count">0</span><span>FOLLOWING</span>
			</a>
		</li>
	</ul>
</div>

<script>
	var base_dp_path = "<?php echo url($user_url) ?>";
	var def_dp = base_dp_path + "dp.png";
	var is_followed = false;
	var followers_count = 0;

	function hideUserBottomSheet(){
		$("#userBottomSheet .cust-modal-content").addClass("collapsed");
		$("#userBottomSheet .cust-modal-content").removeClass("peeking");

		setTimeout(function(){
			$("#userBottomSheet").removeClass("open");
			$("body").removeClass("locked");
			$("#userBottomSheet .cust-modal-content").removeClass("collapsed");

			$("#userBottomSheet #username").text("");
			$("#userBottomSheet #project_count").text("");
			$("#userBottomSheet #house_count").text("");
			$("#userBottomSheet #followers_count").text("");
			$("#userBottomSheet #following_count").text("");
			$("#userBottomSheet #profilePic").css("background-image", "url('" + base_dp_path + "dp.png')");
		},250);
	}

	function showUserBottomSheet(user_id, user_name){
		$("#userBottomSheet").addClass("open loading");
		$("#userBottomSheet .cust-modal-content").addClass("peeking");

		$("body").addClass("locked");
		//		$("#userBottomSheet #username").text(user_name);
		$.get(base_url + '/getUser/' + user_id, function(res){
			console.log(res);
			$("#userBottomSheet #username").text(res.fname + " " + res.lname);
			$("#userBottomSheet #profilePic").css("background-image", "url('" + base_dp_path + res.dp + "')");

			$("#userBottomSheet #project_count").text(res.project_count);
			$("#userBottomSheet #house_count").text(res.house_count);
			$("#userBottomSheet #followers_count").text(res.followers_count);
			$("#userBottomSheet #following_count").text(res.following_count);
			$("#userBottomSheet").removeClass("loading");
		});
	}

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
<!-- </div> -->