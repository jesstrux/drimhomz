@extends('layouts.app')

@section('content')
    @include('layouts.header')

    <style>
    	body{
			background: #eee;
		}

		.nd{
    		background: transparent;
			outline: none;
			border: none;
    	}

		.gradient{
			background: #edf3e1;

			background-image: -webkit-linear-gradient(top left, #312 5%, #213, #112, #312);
			background-image: -o-linear-gradient(top left, #312 5%, #213, #112, #312);
			background-image: linear-gradient(to bottom right, #312 5%, #213, #112, #312);
		}

		#profilePage{
			margin-top: -20px;
			padding: 2px 0; min-height: 200px;
		}

		#profileContent{
			position: relative; 
			/*box-shadow: 0 1px 2px rgba(0,0,0,0.07);*/
		}

        .main-layout{
            -webkit-flex-direction: row-reverse;
            -moz-flex-direction: row-reverse;
            -ms-flex-direction: row-reverse;
            -o-flex-direction: row-reverse;
            flex-direction: row-reverse;
        }

    	.menu{
    		width: 400px;
    	}

    	#slideshowFront{
    		background: transparent; color: #fff;
    		max-width: calc(100% - 400px);
    	}

    	#slideshowFront button{
    		background: transparent;
			outline: none;
			border: none;
    	}

    	#slideshowFront button .material-icons{
    		font-size: 6em
    	}

    	.profile-card{
    		min-height: 300px; background: #fff;
    	}

    	.profile-card .numbers{
    		font-size: 15px; color: #777; 
    		display: block !important;
    	}

    	button.edit-btn{
    		margin-top: 8px;
    		padding: 5px 10px;
    		background: #eee;
    		font-size: 15px;
    		font-weight: 700;
    	}

    	button.edit-btn:hover{
    		background: #ddd;
    	}

    	button.edit-btn:focus, button.edit-btn:active{
    		background: #aaa;
    		color: #fff;
    	}

    	.collection-item{
    		outline: none; 
    		border:none; 
    		background: transparent; 
    		height: 180px; 
    		margin: 8px;
    		width: calc(33.33% - 50px + 14px); 
    		margin-left: 0;
    		background: #f2f2f2; 
    		box-shadow: 0 0 1px rgba(0,0,0,0.27);
    	}

    	.collection-item .layout{
    		font-size: 20px; 
    		text-align: center;
    		position: relative; 
    		height: 100%;
    	}

    	.collection-item .layout span{
    		display: block; margin-bottom: 0;
    	}

    	.shadow{
    		box-shadow: 0 0 3px 1px rgba(0,0,0,.1);
    	}

    	.dh-card, .post-card{
    		border-radius: 2px;
    	}

    	.post-card{
    		background: #fff; 
    		margin: 20px 0;
    	}
    	
    	.post-card h3{
    		font-size: 20px; margin-top: 0; 
    		border-bottom: 1px solid #ddd; 
    		padding: 16px;
    		margin-bottom: 0;
    	}

    	.post-card h3 .secondary{
    		font-size: 15px;
    		font-weight: bold;
    		color: #ff9800;
    	}

    	.post-card .content{
    		position: relative;
    		padding: 8px;
    		padding-left: 16px;
    	}

    	.menu-right{
    		padding: 0 16px; padding-right: 0;
    	}

    	.menu-right h3{
    		font-size: 17px;
    	}

    	.menu-right .empty-message{
    		font-size: 15px
    	}

    	@media all and (min-width: 1200px) {
    		.profile-card{
    			height: 400px;
    		}
    		#slideshowFront{
    			font-size: 1.2em;
    		}
    		#slideshowFront h3{
    			font-size: 1.8em;
    		}
    	}

    	@media all and (max-width: 1000px) {
    		#profilePage{
    			margin-top: 0;
    		}
    		.collection-item{
	    		height: 150px;
	    		width: 150px; 
	    	}
	    	.collection-item .layout{
	    		font-size: 18px;
	    	}
    	}

    	@media all and (max-width: 991px) {
    		#profilePage{
    			position: relative;
    			padding-top: 60px;
    		}
    		.menu{
    			width: 50%;
    		}
    		#slideshowFront{
    			max-width: 50%;
    		}
    		.collection-item{
	    		height: 100px;
	    		width: 100px; 
	    	}
	    	.collection-item .layout{
	    		font-size: 14px;
	    	}
    	}
    	@media all and (max-width: 767px) {
    		#profilePage{
    			margin-top: -15px;
    			padding-top: 0;
    		}
    	}
    	@media all and (max-width: 560px) {
    		#profilePage{
    			padding-top: 0;
    			margin-top: -15px;
    		}
    		#profileContent{
    			margin-left: -20px;
    			width: calc(100vw + 5px);
    		}
    		.profile-card{
    			width: 100%;
    			background: transparent;
    			display: none;
    		}
    		#slideshowFront{
    			min-height: 250px;
    			max-width: 100%;
    		}

    		/*#profilePage .profile-card .section-header h3{
	    		color: #fff;
	    	}

	    	#profilePage .profile-card .section-header p{
	    		color: #e0e0e0;
	    	}

	    	#profilePage .profile-card .section-header .numbers{
	    		color: #bbb;
	    	}

	    	button.edit-btn{
	    		background: rgba(85,85,85,0.5);
	    	}

	    	button.edit-btn:hover{
	    		background: #555;
	    	}

	    	button.edit-btn:focus, button.edit-btn:active{
	    		background: #555;
	    		color: #fff;
	    	}*/

    		/*UNCOMMENT TO SHOW PROFILE CARD INSTEAD*/
    		#profileContent{
    			margin-left: 0;
    			width: calc(100vw - 30px);
    			background: #fafafa;
    		}
    		.profile-card{
    			width: 100%;
    			background: transparent;
    			display: block;
    			min-height: 0;
    			padding: 35px 0;
    		}
    		#slideshowFront{
    			display: none;
    			max-width: 100%;
    		}

    		.menu-right{
    			display: none;
    		}
    		.collection-item{
	    		height: 150px;
	    		width: 33.33%;
	    	}
	    	.collection-item .layout{ 
	    		font-size: 1.3em;
	    	}
    	}
    </style>
    <div id="profilePage">
	    <div class="container">
	    	<div id="profileContent" class="gradient shadow layout main-layout">
	    		<div id="slideshowFront" class="flex layout vertical center-center profile-card">
	    			<button>
	    				<!-- <i class="material-icons">play_circle_outline</i> -->
                        <span class="material-icons">&nbsp;</span>
	    			</button>
	    			<h3 style="margin-top: 10px;">My dream home</h3>
	    		</div>
	    		<div id="menu" class="menu layout center-center profile-card">
	    			<div class="section-header" style="padding: 0; text-align: center;">
	    				<h3 style="margin-bottom: 0;">{{Auth::user()->full_name()}}</h3>
	    				<p style="margin-top: 2px;">
	    					{{Auth::user()->town}}
	    					<br>
	    					<span class="numbers">5 Albums | 23 Houses</span>
	    					<button class="nd edit-btn text-uppercase">Edit profile</button>
	    				</p>
	    			</div>
	    		</div>
	    	</div>

	    	<div class="layout main-layout">
		    	<div class="flex">
		    		<div class="post-card shadow">
		    			<h3 class="layout center justified">Albums <a href="#albums" class="secondary theme-text">View All</a></h3>
			    		<div class="content layout">
			    			<button class="collection-item">
			    				<div class="layout vertical center-center">
			    					<span style="display: block; margin-bottom: 0;">CREATE</span> ALBUM
			    				</div>
			    			</button>
			    		</div>
		    		</div>

		    		<div class="post-card shadow">
		    			<h3 class="layout center justified">Houses <a href="#houses" class="secondary theme-text">View All</a></h3>
			    		<div class="content layout">
			    			<button class="collection-item">
			    				<div class="layout vertical center-center">
			    					<span>ADD</span> HOUSE
			    				</div>
			    			</button>
			    		</div>
		    		</div>
		    	</div>

	    		<div class="menu menu-right">
	    			<h3>Favorite houses</h3>
	    			
	    			<div class="dh-card shadow">
	    				<p class="empty-message">You have favorite no houses</p>
	    			</div>

	    			<h3>Favorite albums</h3>
	    			
	    			<div class="dh-card shadow">
	    				<p class="empty-message">You have favorite no albums</p>
	    			</div>
	    		</div>
	    	</div>
    	</div>
    </div>
@endsection