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

	.room-item{
		background-color: #00C900;
		padding: 3px 6px;
		color: #fff;
		position: relative;
		margin-bottom: 6px;
		margin-right: 6px;
	}

	.room-item .room-count{
		display: inline-block;
		margin-right: 5px;
		background-color: rgba(0, 0, 0, 0.2);
		padding: 1px 6px;
		font-size: 13px;
		align-self: center;
		font-family: Verdana, Geneva, sans-serif;
	}

	.room-item .room-remover{
		height: 24px;
		width: 24px;
		margin: 0;
		padding: 0;
		margin-left: 5px;
		outline: none;
		border: none;
		background-color: rgba(255, 255, 255, 0.3);
	}

	.real-list:not(.my-home) form{
		display: none;
	}

	.room-item .room-remover svg{
		width: 18px !important;
		height: 18px !important;
		fill: #333 !important;
	}


	@media only screen and (max-width: 760px) {
		body{
			background-color: #fff !important;
		}
		.realtor-phone {
			display: inline !important;
		}
		.realtor-name {
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
			<div class="col-lg-12 margin-tb">
				<div class="pull-right">
					<a class="btn btn-primary" href="{{ url('realhomz/rentals') }}"> Back</a>
				</div>
			</div>
		</div>
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
						<div class="hidden-xs" style="height: 19px;"></div>
						@if(!$my_home)
							<p style="font-size: 1.3em; line-height: 1.9em; padding-bottom: 10px;">
								Realtor contact: <span class="hidden-xs"><br>{{$real->user->phone}}</span>
								<a class="hidden realtor-phone" href="tel:{{$real->user->phone}}">{{$real->user->phone}}</a><br>
								<a class="realtor-name" href="/user/{{$real->user->id}}">{{$real->user->fname}} {{$real->user->lname}}</a>
							</p>
							<div class="hidden-xs" style="height: 19px;"></div>
						@else
							<button class="round-btn" style="padding: 5px 20px; min-width: 0; margin-bottom: 10px; margin-top: 15px;" onclick="openNewRental()">Edit Rental</button>
						@endif
						<hr>
					</div>

					<div class="card-body" style="padding: 24px; padding-top: 1px;">
						<h3 style="margin-top: 20px;">
							Features

							@if($my_home)
								<a onclick="openAddRooms()" href="javascript:void(0);" style="float: right; font-size: 0.8em; font-weight: bold; margin-right: 8px;">Add</a>
							@endif
						</h3>

						<?php
							$rooms = $real->utilities_rooms();
							$rooms_count = $rooms->count();

							$content_available = $rooms_count > 0 ? "" : "no-content";
						?>
						<div class="rooms-list real-list {{$content_available}} {{$my_home_class}}">
							<div class="the-list">
								@if($rooms_count > 0)
									@foreach($rooms as $room)
										<span id="room{{$room->id}}" class="room-item layout inline">
											@if($room->type == "room")
												<span class="room-count">{{$room->count}}</span>
											@endif

											{{$room->name}}
											<form id="removeRoom{{$room->id}}" action="/removeRoomFromRental" onsubmit="removeRoom(event, '{{$room->id}}')" method="post">
												{{csrf_field()}}
												<input type="hidden" name="home_utility_id" value="{{$room->id}}">
												<button type="submit" class="room-remover layout center-center">
													<svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
												</button>
											</form>
										</span>
									@endforeach
								@endif
							</div>

							<span class="empty-message mine">
								Click 'add' to set features for this home
							</span>

							<span class="empty-message">
								No features provided for this home.
							</span>
						</div>
						<br><hr>
					</div>

					<div class="card-body" style="padding: 24px; padding-top: 1px; margin-top: -18px;">
						<div class="hidden-xs" style="height: 1px;"></div>
						<h3>More info:</h3>
						<div class="hidden-xs" style="height: 3px;"></div>
						<p style="font-size: 1.4em; margin-top: 6px;margin-bottom: 25px;">
							<strong style="display: inline-block; margin-top: 1;color: #ffa500; font-weight: bold;letter-spacing: 0.25em;font-size: 0.7em;">Town:</strong> &nbsp;
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
				</div>
			</div>

			<div class="col-md-5 hidden-xs hidden-sm" style="padding-top: 0;">
				<h3 style="padding-top: 0; margin-top: 0; margin-bottom: 20px;">PICTURES</h3>
				@include('realhomz.real_pictures')
			</div>
		</div>
	</div>
</div>

@include('realhomz.manage_rooms')
@include('realhomz.add_pictures')
@include('realhomz.new_rental')