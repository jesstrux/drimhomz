@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <style>
    	body{
			background-color: #f8f8f8;
		}
    	#profileSummaryLg{
			display: none;
		}

		#profileSummary{
			padding: 0;
			background-color: #ccc;
			box-shadow: 0 2px 1px rgba(0,0,0,0.15);
			/*margin-bottom: 5px;*/
			z-index: 1;
			/*position: relative;*/
		}
		#lgDp{
			position: relative;
			max-height: 350px;
			overflow: hidden;
		}
		#lgDp img{
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
			background-color: #ddd;
			height: 75px;
			/*padding: 10px 0;*/
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
			font-weight: bold;
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

		@media all and (min-width: 1200px) {
			#userDetails{
				margin: 0 20px;
			}
		}

		#userHouses{
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
        
        #userHouses .house-card, .new-button{
            width: calc(50% - 10px);
            display: inline-block;
            margin: 0 5px;
            margin-bottom: 15px; 
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 1px rgba(0,0,0,0.35);
            padding: 8px;
        }

        #userHouses .house-card .content h3{
        	font-size: 1.2em;
        	margin-bottom: 5px;
        	margin-top: 15px;
        }

        #userHouses .house-card .content .social-stuff{
        	font-size: 0.9em;
        }

        #userHouses .house-card .content .social-stuff span{
        	font-size: 0.8em;
        }

        #userHouses .house-card .image, .new-button .image{
        	height: 150px; overflow: hidden;
            border-radius: 5px;
            background-color: #f4f4f4;
        }

        #userHouses .house-card .image img{
            height: 100%;
            min-width: 100%;
        }

        @media all and (min-width: 900px) {
            #userHouses .new-button, #userHouses .house-card{
                width: calc(33.333% - 10px);
                padding: 16px;
            }

            #userHouses .house-card .image, .new-button .image{
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

    <?php 
    	$houses = $user->houses;
    	$house_count = $houses->count();
    	$no_houses = $house_count < 1;
    ?>
    <main class="container-fluid">
		<div class="row">
			<div id="profileSummaryLg" class="col-sm-12 col-md-5 col-lg-4">
				<div id="userDetails" class="text-center">
					<div id="profilePic">
						<img src='{{asset("images/uploads/$user->dp")}}' 
						alt="{{$user->fname}}'s dp">
					</div>
					<h3>{{$user->full_name()}}</h3>
					@if(isset($user->town))
						<p>From {{$user->town}} <br>Vendor</p>
					@else
						<br>
					@endif

					@if($myProfile)
						<a href="/setupAccount" class="btn btn-default" style="">
							Edit profile
						</a>
					@else
						<button class="btn btn-default">FOLLOW</button>
					@endif
					<!-- <hr> -->
				</div>
			</div>

			<div id="profileSummary" class="col-sm-12 col-md-4">
				<div id="lgDp">
					<img src='{{asset("images/uploads/$user->dp")}}' 
						alt="{{$user->fname}}'s dp">
					<div id="user">
						<span id="name">{{$user->full_name()}}</span>
						<span id="profession">{{$user->town}}</span>

						@if($myProfile)
							<button id="followBtn">
								<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
								    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
								    <path d="M0 0h24v24H0z" fill="none"/>
								</svg>
							</button>
						@else
							<button id="followBtn" class="followed">
								<svg fill="#000000" height="30" viewBox="0 0 24 24" width="30" xmlns="http://www.w3.org/2000/svg">
								    <path d="M0 0h24v24H0z" fill="none"/>
								    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
								</svg>
							</button>
						@endif
					</div>
				</div>
				<div class="tabheads">
					<div class="tabhead active"><span>{{$house_count}}</span><span>HOUSES</span></div>
					<div class="tabhead"><span>5</span><span>ALBUMS</span></div>
					<div class="tabhead"><span>3</span><span>FOLLOWING</span></div>
				</div>
			</div>
			<div id="tabsContent" class="col-sm-12 col-md-7 col-lg-8">
				<div class="tabheads hidden-sm hidden-xs">
					<a href="#" class="tabhead active"><span>{{$house_count}}</span><span>HOUSES</span></a>
					<a href="#" class="tabhead"><span>5</span><span>ALBUMS</span></a>
					<a href="#" class="tabhead"><span>3</span><span>FOLLOWING</span></a>
					<a href="#" class="tabhead"><span>23</span><span>FOLLOWERS</span></a>
				</div>

				<div id="userHousesWrapper" style="margin-top: 20px;">
					<div id="userHouses" style="padding: 0;">
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
				        	@if($no_houses)
				        		<div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
				        			{{$user->fname}} hasn't added any houses yet.
				        		</div>
				        	@endif
						@endif

				        @foreach($houses as $house)
				            <?php
				                $trailingS = $house->fav_count == 1 ? "" : "s";
				                $likes_text = $house->fav_count. " like".$trailingS;

				                $trailingS = $house->comment_count == 1 ? "" : "s";
				                $comments_text = $house->comment_count. " comment".$trailingS;
				            ?>
				            <!-- <div class="grid-sizer"></div> -->
				            <div class="house-card">
				                <div class="image">
				                    <img src="{{asset($house->image_url)}}" alt="modern bath">
				                </div>
				                <div class="content">
				                    <h3>{{$house->title}}</h3>
				                    <span class="social-stuff">
				                    	{{$likes_text}} <span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}
				                    </span>
				                </div>
				            </div>
				        @endforeach
				    </div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{asset('js/wookmark.min.js')}}"></script>
    <script src="{{asset('js/imagesLoaded.min.js')}}"></script>
	<script>
		var container = "#userHousesWrapper";
		var wookmark = undefined;
		// var options = {
		// 	align: 'center',
		// 	autoResize: false,
		// 	comparator: null,
		// 	container: $('body'),
		// 	direction: undefined,
		// 	ignoreInactiveItems: true,
		// 	itemWidth: 0,
		// 	fillEmptySpace: true,
		// 	flexibleWidth: 0,
		// 	offset: 2,
		// 	onLayoutChanged: undefined,
		// 	outerOffset: 0,
		// 	possibleFilters: [],
		// 	resizeDelay: 50,
		// 	verticalOffset: undefined
		// };


		var options = {
			container: $('#userHousesWrapper'),
			itemWidth: '40%',
			flexibleWidth: '40%',
			offset: 2,
			resizeDelay: 50
		};

		// $('#userHouses').wookmark(options);


		// imagesLoaded(container, function () {
	 //      if (wookmark === undefined) {
	 //        wookmark = new Wookmark(container, {
	 //          offset: 10
	 //        });
	 //      } else {
	 //        wookmark.initItems();
	 //        wookmark.layout(true);
	 //      }

	 //      $(".house-card.grid-item").each(function () {
	 //        var $self = $(this);
	 //        window.setTimeout(function () {
	 //          $self.css('opacity', 1);
	 //        }, Math.random() * 2000);
	 //      });
	 //    });
	</script>
@endsection 