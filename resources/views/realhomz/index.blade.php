@extends('layouts.app')

@section('content')
	<?php
	if(!Auth::guest())
		$user = Auth::user();
	?>
	<style>
		body{
			background-color: #eee !important;
			/*ECECEC;*/
			/*background-color: #ccc;*/
		}
		.tab-links{
			font-size: 1.6em;
		}
		.tab-links a{
			display: inline-block;
			color: inherit;
			font-family: inherit;
			margin-bottom: 17px;
		}
		.tab-links a.active{
			font-weight: bold;
			color: #444;
			pointer-events: none;
		}
		.card {
			position: relative;
			margin-bottom: 24px;
			background-color: #ffffff;
			color: #313534;
			border-radius: 2px;
			-webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
		}
		.card:before,
		.card:after {
			content: " ";
			display: table;
		}
		.card:after {
			clear: both;
		}
		.card.no-pad{
			padding: 0;
		}
		.item, .item-text{
			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
		}
		.item{
			/*background-color: red;*/
			padding: 16px;
			-ms-align-items: center;
			align-items: center;
			border-bottom: 1px solid #ddd;
		}
		.avatar{
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: #ddd;
			overflow: hidden;
			margin-right: 16px;
		}
		.item-text{
			-webkit-flex-direction: column;
			-moz-flex-direction: column;
			-ms-flex-direction: column;
			-o-flex-direction: column;
			flex-direction: column;

			/*background-color: blue;*/

			-webkit-flex: 1px;
			-moz-flex: 1px;
			-ms-flex: 1px;
			-o-flex: 1px;
			flex: 1px;
		}
		.item-text h3{
			font-size: 16px;
			font-weight: 700;
		}
		.item-text h3, .item-text p{
			margin: 0;
			padding: 0;
		}
		.item .secondary, .item-text p{
			color: #999;
			line-height: 15px;
		}
		.item .secondary{
			font-size: 12px;
		}

		.item + .card-body{
			padding: 16px;
			padding-top: 12px;
		}


		.item + .card-body{
			font-size: 16px;
		}

		.real-content{
			background: #fff;
			max-width: 900px;
			margin: 10px auto;
			padding: 40px 20px;
		}

		@media only screen and (max-width: 760px) {
			.real-content{
				margin: 0 auto;
				padding: 20px;
			}
		}
	</style>

	<section class="short" style="background-color: #fff; padding-bottom: 20px;">
		<div class="container">
			<div class="section-header text-center" style="background: #fff; max-width: 900px; margin: 10px auto; padding:20px; padding-top: 0;">
				<h3 style="font-size: 3em; margin: 20px;">Real Homz</h3>
				{{--<br>--}}
				<?php
				$homes_active = $page == "homes" ? "active" : "";
				$rentals_active = $page == "rentals" ? "active" : "";
				$plots_active = $page == "plots" ? "active" : "";
				?>

				<h4 class="tab-links" style="margin-top: 30px; margin-bottom: 15px;">
					<a href="{{url('realhomz/homes')}}" class="{{$homes_active}}">
						HOMES
					</a> &nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="{{url('realhomz/rentals')}}" class="{{$rentals_active}}">RENTALS</a> &nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="{{url('realhomz/plots')}}" class="{{$plots_active}}">PLOTS</a>
				</h4>

				@if(Auth::user() && Auth::user()->role != 'realtor')
					@if($page == "homes")
						<button class="round-btn" style="padding: 5px 20px; min-width: 0; margin-bottom: 10px; margin-top: 15px;" onclick="openNewHome()">Add Home</button>
					@elseif($page == "rentals")
						<button class="round-btn" style="padding: 5px 20px; min-width: 0; margin-bottom: 10px; margin-top: 15px;" onclick="openNewRental()">Add Rental</button>
					@elseif($page == "plots")
						<button class="round-btn" style="padding: 5px 20px; min-width: 0; margin-bottom: 10px; margin-top: 15px;" onclick="openNewPlot()">Add Plot</button>
					@endif
				@endif
			</div>
		</div>
	</section>

	<br>
	<div class="real-content">
		@include('realhomz.'.$page)
		@include('realhomz.new_'.substr($page, 0, strlen($page) - 1))
	</div>
	<br>
@endsection