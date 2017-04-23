@extends('layouts.app')

@section('content')
	<?php
		$my_home = false;

		if(!Auth::guest()){
			$user = Auth::user();
			$my_home = $user->id == $real->user_id;
		}

		$my_home_class = $my_home ? "my-home" : "";

		$image_url_map = [
			"home" => $home_url,
			"rental" => $rental_url,
			"plot" => $plot_url
		];

		$image_base_url = $image_url_map[$page];
		$add_rooms_url = "/addRoomsTo".ucfirst(trans($page));
		$utilities = $page;
		$remove_room_url = "/removeRoomFrom".ucfirst(trans($page));
		$add_pictures_url = "/addPicturesTo".ucfirst(trans($page));

		$cur_real = $real;
	?>

	<style>
		.realPictures .real_pics{
			-webkit-transition: all 0.35s;
			-moz-transition: all 0.35s;
			-ms-transition: all 0.35s;
			-o-transition: all 0.35s;
			transition: all 0.35s;
		}
	</style>

	@include('realhomz.single_'.$page)

	<script>
		var is_new = <?php echo $is_new ? "true" : "false"; ?>;
		console.log(is_new);
		$(document).ready(function () {
			if(is_new)
				showToast("success", "Fill in the remaining info.", 4000, "topCenter");
		});

		var real_images = <?php echo $real->images->toJson(); ?>;
		var real_interval = null;

		if(real_images.length > 1){
			var real_image_count = 0;
			realIt();
		}

		function realIt(){
			real_interval = setInterval(function(){
				real_image_count = real_image_count < real_images.length - 1 ? real_image_count + 1 : 0;
				var real_image = real_images[real_image_count];
				var uri = "<?php echo $image_base_url; ?>" + real_image.url;
				$(".realPictures .real_pics").css({"background-color": real_image.placeholder_color, "background-image": "url("+uri+")"});
			}, 4000);
		}

		function ongezaImages(images){
			console.log(images);

			if(images && images.length){
				if(real_interval != null){
					clearInterval(real_interval);
				}

				for(var i = 0; i < images.length; i++){
					real_images.push(images[i]);
				}

				console.log(real_images);

				realIt();
			}
		}
	</script>
@endsection