@extends('layouts.app')

@section('content')
	<?php
		$my_home = false;

		if(!Auth::guest()){
			$user = Auth::user();
			$my_home = $user->id == $real->user->id;
		}

		$my_home_class = $my_home ? "my-home" : "";
	?>
	<style>
		body{
			background-color: #eee !important;
			/*ECECEC;*/
			/*background-color: #ccc;*/
		}

		.real-list .empty-message{
			display: none;
		}

		.real-list.no-content{
			background-color: #ECECEC;
		}

		.real-list.no-content:not(.my-home) .empty-message:not(.mine){
			display: inline-block;
		}

		.real-list.no-content.my-home .empty-message.mine{
			display: inline-block;
		}
	</style>

	<div class="container">
		<div style="max-width: 1100px; margin: 20px auto;">
			<div class="row">
				<div class="col-md-8 col-lg-7" style="position: relative;">
					<div class="card">
						<div class="card-body" style="padding: 24px; padding-bottom: 0;">
							<h3 style="font-size: 2.3em;">{{$real->name}}</h3>
							<p style="font-size: 1.4em; margin-top: 6px;margin-bottom: 25px;">
								<strong style="letter-spacing: 0.25em;font-size: 0.7em;">PRICE:</strong> &nbsp;Tshs. <span style="etter-spacing: 0.1em">{{number_format( $real->price / 100, 0 )}}</span>
							</p>
							<p style="font-size: 1.3em; line-height: 1.9em; padding-bottom: 29px;">{{$real->description}}</p>
							<hr>
						</div>

						<div class="card-body" style="padding: 24px; padding-top: 1px;">
							<h3 style="margin-top: 20px;">
								Rooms

								@if($my_home)
									<a href="javascript:void(0);" style="float: right; font-size: 0.8em; font-weight: bold; margin-right: 8px;">Add</a>
								@endif
							</h3>

							<?php
								$rooms = $real->utilities_rooms();
								$rooms_count = $rooms->count();

								$content_available = $rooms_count > 0 ? "" : "no-content";
							?>
							<div class="real-list {{$content_available}} {{$my_home_class}}">
								<div class="the-list">
									@if($rooms_count > 0)
										@foreach($rooms as $room)
											{{$room->name}}

											@if($loop->iteration < $rooms_count - 1)
												,&nbsp;
											@endif
										@endforeach
									@endif
								</div>

								<span class="empty-message mine">
									Click 'add' to choose rooms available for this home
								</span>

								<span class="empty-message">
									No rooms provided for this home.
								</span>
							</div>

							<h3 style="margin-top: 50px;">
								Features

								@if($my_home)
									<a href="javascript:void(0);" style="float: right; font-size: 0.8em; font-weight: bold; margin-right: 8px;">Add</a>
								@endif
							</h3>
							<?php
								$features = $real->utilities_features();
								$features_count = $features->count();

								$content_available = $features_count > 0 ? "" : "no-content";
							?>
							<div class="real-list {{$content_available}} {{$my_home_class}}">
								<div class="the-list">
									@if($features_count > 0)
										@foreach($features as $feature)
											{{$feature->name}}

											@if($loop->iteration < $features_count - 1)
												,&nbsp;
											@endif
										@endforeach
									@endif
								</div>

								<span class="empty-message mine">
									Click 'add' to choose features available for this home
								</span>

								<span class="empty-message">
									No features provided for this home.
								</span>
							</div>
						</div>
						<br>
					</div>
				</div>

				<div class="col md-4 col-lg-5" style="padding-top: 0;">
					<h3 style="padding-top: 0; margin-top: 0; margin-bottom: 20px;">PICTURES</h3>
					<div style="position: relative;">
						@if($real->images->count() > 0)
							<div class="card" style="margin-bottom: 20px;">
								<div style="background: #fefefe; position: relative; height: 250px; overflow: hidden;">
									@foreach($real->images as $image)
										<img src="{{$home_url . $image->image_url}}" alt="{{$image->caption}}" width="100%">
									@endforeach
								</div>
							</div>
						@else
							<div class="card" style="height: 300px; margin-bottom: 20px; background-image: url({{$home_url . $real->image()}}); background-position: center; background-size: cover"></div>
						@endif

						@if($my_home)
							<a href="javascript:void(0);" class="a-fab lg" style="position: absolute; bottom: -28px; right: 20px;">
								<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M9 3L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3.17L15 3H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zM12 17l1.25-2.75L16 13l-2.75-1.25L12 9l-1.25 2.75L8 13l2.75 1.25z"/></svg>
							</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var is_new = "<?php echo $is_new ? true : false ; ?>";
		console.log(is_new);

		$(document).ready(function () {
			if(is_new)
				showToast("success", "Fill in the remaining info.", 4000, "topCenter");
		});
	</script>
@endsection