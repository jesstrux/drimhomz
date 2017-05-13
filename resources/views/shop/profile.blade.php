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
		}
		@media all and (min-width: 1200px) {
			#userDetails{
				margin: 0 20px;
			}
		}

    </style>

    <?php
    	$houses = $shop->products;
	    $house_count = count($houses);
    ?>
    <main class="container-fluid">
		<div class="row">
			@include('shop.profile_summary')

			<div class="col-sm-12 col-md-8">
				@include('shop.sections')
			</div>
		</div>
	</main>

    <script src="{{asset('js/jquery.rateyo.min.js')}}"></script>
    @include('rating.rate_it')
    <script>
	    function ratingSet(formdata){
		    var shop = "<?php echo $shop->id; ?>";
		    formdata.append("shop_id", shop);
//		    showLoading();
		    console.log(formdata.getAll("shop_id"));
		    console.log(formdata.getAll("rating"));
		    console.log(formdata.getAll("comment"));
	    }
    </script>
@endsection