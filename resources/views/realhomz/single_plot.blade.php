<style>
	body{
		background-color: #eee !important;
		/*ECECEC;*/
		/*background-color: #ccc;*/
	}

	@media only screen and (max-width: 760px) {
		body{
			background-color: #fff !important;
		}
		.realtor-phone {
			display: inline !important;
		}

		#homeInfo{
			padding: 0;
			margin-top: -40px;
		}

		#homeInfo > .card{
			box-shadow: none;
			margin: 0;
		}

		#homeInfo > .card .card-body{
			padding-top: 5px !important;
		}
	}
</style>

<div class="container">
	<div style="max-width: 1100px; margin: 20px auto;">
		<div class="row">
			<div id="homeInfo" class="col-md-7" style="position: relative;">
				<div class="card">
					<div class="hidden visible-xs visible-sm" style="position: relative;">
						@include('realhomz.real_pictures')
					</div>

					<div class="card-body" style="padding: 24px; padding-bottom: 0;">
						<h3 style="font-size: 2.3em;">{{$real->name}}</h3>
						<p style="font-size: 1.4em; margin-top: 6px;margin-bottom: 25px;">
							<strong style="color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">PRICE:</strong> &nbsp;Tshs. <span style="etter-spacing: 0.1em">{{number_format( $real->price, 0 )}}</span>
						</p>
						<p style="font-size: 1.3em; line-height: 1.9em; padding-bottom: 10px;">{{$real->description}}</p>
						@if(!$my_home)
							<div class="hidden-xs" style="height: 19px;"></div>
							<p style="font-size: 1.3em; line-height: 1.9em; padding-bottom: 10px;">
								Realtor contact: <span class="hidden-xs">{{$real->user->phone}}</span>
								<a class="hidden realtor-phone" href="tel:{{$real->user->phone}}">{{$real->user->phone}}</a>
							</p>
							<div class="hidden-xs" style="height: 19px;"></div>
						@else
							<button class="round-btn" style="padding: 5px 20px; min-width: 0; margin-bottom: 10px; margin-top: 15px;" onclick="openNewPlot()">Edit Plot</button>
						@endif
						<hr>
						<div class="hidden-xs" style="height: 1px;"></div>
						<h3>More info:</h3>
						<div class="hidden-xs" style="height: 3px;"></div>
						<p style="font-size: 1.4em; margin-top: 6px;margin-bottom: 25px;">
							<strong style="color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">Size:</strong> &nbsp; <span style="etter-spacing: 0.1em">{{number_format( $real->size / 100, 0 )}} square meters</span><br>

							<strong style="display: inline-block; margin-top: 18px;color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">Topography:</strong>&nbsp;
							@if($real->topographical_nature && strlen($real->topographical_nature) > 0)
								<span style="etter-spacing: 0.1em">{{$real->topographical_nature}}</span><br>
							@else
								<span style="etter-spacing: 0.1em">Unknown</span><br>
							@endif

							<strong style="display: inline-block; margin-top: 18px;color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">Town:</strong> &nbsp;
								@if($real->town && strlen($real->town) > 0)
									<span style="etter-spacing: 0.1em">{{$real->town}}</span><br>
								@else
									<span style="etter-spacing: 0.1em">Unknown</span><br>
								@endif

							<strong style="display: inline-block; margin-top: 18px;color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">Street:</strong> &nbsp;
							@if($real->street && strlen($real->street) > 0)
								<span style="etter-spacing: 0.1em">{{$real->street}}</span><br>
							@else
								<span style="etter-spacing: 0.1em">Unknown</span><br>
							@endif
						</p>
					</div>
					<br>
				</div>
			</div>

			<div class="col-md-5 hidden-xs hidden-sm" style="padding-top: 0;">
				<h3 style="padding-top: 0; margin-top: 0; margin-bottom: 20px;">PICTURES</h3>
				@include('realhomz.real_pictures')
			</div>
		</div>
	</div>
</div>

@include('realhomz.add_pictures')
@include('realhomz.new_plot')