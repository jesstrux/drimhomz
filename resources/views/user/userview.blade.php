@if(!Auth::guest() && $myProfile)
	<?php $is_my_profile = true; ?>
@endif

@extends('layouts.app')

@section('content')
    <style>
		@media only screen and (max-width: 760px) {
	        body{
	            background-color: white !important;
	        }
    	}
		a{
			color: inherit;
			text-decoration: none;
		}
    	#profileSummaryLg{
			display: none;
		}

		#profileSummary{
			padding: 0;
			background-color: #ccc;
			background-image: -webkit-linear-gradient(top left, #eee, #fefefe);
			background-image: -o-linear-gradient(top left, #eee, #fefefe);
			background-image: linear-gradient(to bottom right, #eee, #fefefe);
			/*margin-bottom: 5px;*/
			z-index: 1;
			/*position: relative;*/
		}
		#lgDp{
			position: relative;
			/*max-height: 350px;*/
			overflow: hidden;
		}
		#lgDp #cover{
			height: 230px;
			margin: 30px 0;
		}
		
		#lgDp #cover #theDp{
			width: 150px;
			height: 150px;
			overflow: hidden;
			border-radius: 50%;
			margin: auto;
		}

		#lgDp #theDp img{
			width: 100%;
		}

		#lgDp #user{
			padding: 20px 20px;
			padding-bottom: 25px;
			background-color: rgba(35,30,43,0.8);
			padding-right: 70px;
			color: #fff;
			position: absolute;
			bottom: 0;
			width: 100%;

			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
			-webkit-flex-direction: column;
			-moz-flex-direction: column;
			-ms-flex-direction: column;
			-o-flex-direction: column;
			flex-direction: column;
		}
		#lgDp #user #name{
			font-size: 2.2em;
			line-height: 1em;
			font-family: Verdana, Geneva, sans-serif;
			margin-bottom: 10px;
		}
		#lgDp #user #profession{
			font-size: 1.7em;
			line-height: 0.7em;
			font-family: serif;
			letter-spacing: 2px;
		}
		#followBtn{
			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
			-ms-align-items: center;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			width: 50px;
			height: 50px;
			border: 2px solid #EEE9D8;
			background-color: transparent;
			position: absolute;
			right: 16px;
			bottom: 20px;
		}
		#followBtn svg{
			fill: #EEE9D8;
		}
		#followBtn.followed{
			border:none;
			background-color: #ffa500;
		}
		#followBtn.followed svg{
			fill: #231e2b;
			fill: #000;
		}
		.tabheads{
			height: 75px;
			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
			justify-content: space-between;
			-ms-align-items: center;
			align-items: center;
		}
		.tabheads .tabhead{
			display: inline-block;
			min-width: calc(33.333% - 4px);
			margin: 0 2px;
			text-align: center;
		}

		.tabheads .tabhead span{
			display: block;
			font-size: 1em;
		}

		.tabheads .tabhead span:first-child{
			color: #009688;
			color: #231E2B;
			font-size: 1.5em;
			letter-spacing: 3px;
		}

		#tabsContent{
			/*background-color: #231E2B;*/
		}

		.tabheads .tabhead.active span{
			color: #ffa500;
		}

		.tabheads .tabhead.active span:first-child{
			/*font-weight: bold;*/
		}

		@media all and (min-width: 768px) {
			main{
				padding: 20px 50px !important;
			}

			#profileSummary{
				display: none;
			}

			#profileSummaryLg{
				display: -webkit-flex;
				display: -moz-flex;
				display: -ms-flex;
				display: -o-flex;
				display: flex;
				justify-content: center;
			}

			#userDetails{
				padding: 20px 0;
				padding-bottom: 45px;
				background-color: #fff;
				box-shadow: 0 0 3px rgba(0,0,0,0.16);
				border-radius: 3px;
				min-width: 320px;
				position: relative;
				margin: auto;
			}

			#userDetails h3{
				font-size: 1.6em;
				margin-bottom: 0;
			}

			#userDetails p{
				font-size: 1.2em;
				margin-bottom: 10px;
			}

			#userDetails button{
				min-width: 150px;
			}

			#userDetails hr{
				/*margin: 40px;*/
				margin-bottom: 20px;
			}

			#userDetails #links{
				/*display: inline-block;*/
				min-width: 200px;
			}

			#userDetails #links a{
				display: block;
				font-size: 1.15em;
				/*text-align: left;*/
				padding: 10px;
				text-transform: uppercase;
			}

			#userDetails #links a.active{
				font-weight: bold;
			}

			#profileSummaryLg #profilePic{
				position: relative;
				width: 100px;
				height: 100px;
				border-radius: 50%;
				overflow: hidden;
				margin: 20px auto;
			}

			#profileSummaryLg #profilePic img{
				height: 100%;
			}

			#tabsContent{
				background-color: transparent;
			}

			#tabsContent .tabheads{
				/*padding: 20px 0;*/
				background-color: #fff;
				box-shadow: 0 0 3px rgba(0,0,0,0.16);
				border-radius: 3px;
				height: 70px;
			}

			#tabsContent .tabheads .tabhead{
				display: inline-block;
				min-width: calc(25% - 4px);
				margin: 0 2px;
				text-align: center;
				color: inherit;
			}
		}

		@media all and (max-width: 767px) {
			#tabsContent{
				padding: 0 6px;
			}

			.house-card{
				padding: 0 !important;
				background-color: #f00;
				border-radius: 2px;
			}

			.house-card .image, .house-card .image img,
			.house-card > div{
				overflow: hidden;
				border-radius: 8px 8px 0 0 !important;
			}

			.house-card .content{
				padding: 4px 14px;
				padding-bottom: 10px;
			}
		}

		@media all and (min-width: 1200px) {
			#userDetails{
				margin: 0 20px;
			}
		}

		#userHouses .tab-pane{
            list-style: none;
            display: block;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            -moz-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            -o-flex-wrap: wrap;
            flex-wrap: wrap;
            position: relative;
            padding: 0;
            margin: 0;
        }
        
        #userHouses .tab-pane .house-card, .new-button{
            width: calc(50% - 10px);
            display: inline-block;
            margin: 0 5px;
            margin-bottom: 15px; 
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 1px rgba(0,0,0,0.35);
            padding: 8px;
        }

        #userHouses .tab-pane .house-card .content h3{
        	font-size: 1.2em;
        	margin-bottom: 5px;
        	margin-top: 15px;
        	white-space: nowrap;
        	overflow: hidden;
        	-ms-text-overflow: ellipsis;
        	text-overflow: ellipsis;
        }

        #userHouses .tab-pane .house-card .content .social-stuff{
        	font-size: 0.9em;
        	display: inline-block;
        	width: 100%;
        	white-space: nowrap;
        	overflow: hidden;
        	-ms-text-overflow: ellipsis;
        	text-overflow: ellipsis;
        }

        #userHouses .tab-pane .house-card .content .social-stuff span{
        	font-size: 0.8em;
        }

        #userHouses .tab-pane .house-card .image, .new-button .image{
        	height: 150px; overflow: hidden;
            border-radius: 5px;
            background-color: #f4f4f4;
        }

        #userHouses .tab-pane .house-card .image img,
		#userHouses .tab-pane .house-card .image .userview-image{
            height: 100%;
            min-width: 100%;
        }

        @media all and (min-width: 900px) {
            #userHouses .tab-pane .new-button, #userHouses .tab-pane .house-card{
                width: calc(33.333% - 10px);
                padding: 16px;
            }

            #userHouses .tab-pane .house-card .image, .new-button .image{
	        	height: 200px; overflow: hidden;
	            border-radius: 5px;
	            background-color: #f4f4f4;
	        }
        }

        .house-card p{
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            -ms-text-overflow: ellipsis;
            text-overflow: ellipsis;
        }
    </style>

    <script>
    	var _token = '<input type="hidden" name="_token" value="'+ '<?php echo csrf_token(); ?>' +'">';
	    var cur_user = <?php echo $user; ?>;
    </script>

    <?php
		$followed = false;
		if(!Auth::guest() && !$myProfile)
			$followed = $user->followed(Auth::user()->id);
		$followed_str = $followed ? "followed" : "follow";

	    $projects = $user->projects;
	    $project_count = count($projects);

	    $houses = $user->houses;
	    $house_count = count($houses);

	    $following = $user->following;
	    $following_count = count($following);

	    $followers = $user->followers;
	    $followers_count = count($followers);

		$articles = $user->articles;
		$articles_count = count($articles);

		$shops = $user->shops;
		$shops_count = count($shops);

		$reviews = $user->ratings;
		$reviews_count = count($reviews);

	    if(!isset($page))
	    	$page = "houses";

	    $curpage = 'user.' . $page;

	    function is_curpage($page, $my_page){
	    	return $page == $my_page ? "active" : "";
	    }
	?>

    <main class="container-fluid">
		<div class="row">
			<?php $is_followed = $followed; ?>
			@include('user.profile_summary')

			<div id="tabsContent" class="col-sm-12 col-md-8 col-lg-8">
				<div class="tabheads hidden-xs">
					@if($user->role == "user")
						<a href="/user/{{$user->id}}/projects" data-target="projects" class="tabhead {{is_curpage($page, 'projects')}}"><span>{{$project_count}}</span><span>PROJECTS</span></a>

						<a href="/user/{{$user->id}}/houses" data-target="houses" class="tabhead {{is_curpage($page, 'houses')}}"><span>{{$house_count}}</span><span>DREAMS</span></a>

						<a href="/user/{{$user->id}}/following" data-target="following" class="tabhead {{is_curpage($page, 'following')}}"><span>{{$following_count}}</span><span>FOLLOWING</span></a>
					@endif

					@if($user->role == "expert" || $user->role == "realtor" || $user->role == "seller")
						<a href="/user/{{$user->id}}/articles" data-target="articles" class="tabhead {{is_curpage($page, 'articles')}}"><span>{{$articles_count}}</span><span>ARTICLES</span></a>
						<a href="/user/{{$user->id}}/reviews" data-target="reviews" class="tabhead {{is_curpage($page, 'reviews')}}"><span>{{$reviews_count}}</span><span>REVIEWS</span></a>
					@endif

					@if($user->role == "seller")
						<a href="/user/{{$user->id}}/shops" data-target="shops" class="tabhead {{is_curpage($page, 'shops')}}"><span>{{$shops_count}}</span><span>SHOPS</span></a>
					@endif

					<a href="/user/{{$user->id}}/followers" data-target="followers" class="tabhead {{is_curpage($page, 'followers')}}"><span class="follower_count">{{$followers_count}}</span><span>FOLLOWERS</span></a>
				</div>

				<div id="userHouses" style="margin-top: 20px;">
					<!-- @include('user.houses') -->

					@if($errors->any())
						<div class="alert alert-error alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Error!</strong>{{$errors->first()}}
						</div>
					@endif

					@if (\Session::has('success'))
					    <div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Success!</strong> {!! \Session::get('success') !!}
						</div>
					@endif

				  <div role="tabpanel" class="tab-pane fade in active" id="projects">
				  	@include($curpage)
				  </div>
				</div>
			</div>
		</div>
	</main>

	@include('user.profile-picture')
	@include('user.become_seller')

	@include('shop.new-shop')

	<script>
		function shopCreationSuccess(project){
			showToast("success", "Project created!");

			var proj_html = `<a href="/shop/`+project.id+`" class="house-card">
					<div class="image" style="pointer-events: auto;">
					<img src="`+ shop_base_url + `/def.png"/>
					</div>
					<div class="content">
					<h3 style="line-height: 30px;margin: 0; margin-top: 4px;">`+project.name+`</h3>
			</div>
			</a>`;

			var new_project = $(proj_html);
			$("#createShopBtn").after(new_project);
		}

		function projectCreationError(msg){
			var message = msg && msg.length ? msg : "Couldn't create shop!";
			showToast("error", message);
		}

		function infoSaved(message){
    		var alert = $("#savedAlert");
    		alert.find('.msg').text(message);
    		alert.show();
			setTimeout(function(){
    			alert.hide();
    		}, 2000);
    	}
	</script>
@endsection