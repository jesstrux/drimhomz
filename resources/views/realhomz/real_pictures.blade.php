<style>
	.real_pics > div{
		min-width:100%;max-width:100%; background-position: center; background-size: cover;
	}
</style>
<div class="realPictures" style="position: relative;">
	<div class="card" style="position: relative;height: 300px; margin-bottom: 20px;overflow: hidden;">
		<?php
			$btns_class = $real->images->count() > 1 ? "" : "hidden";
		?>
		<div class="slideshow-controls layout justified center {{$btns_class}}" style="z-index: 9;height: 300px; width: 100%; position: absolute; top: 0; left: 0; background-colo: rgba(0,0,0,0.2)">
			<button onclick="prevSlide()" class="layout center-center" style="width: 44px; height: 44px; border-radius: 50%; background-color: rgba(0,0,0,0.6); margin-left: 8px; border: none">
				<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
			</button>

			<button onclick="nextSlide()" class="layout center-center" style="width: 44px; height: 44px; border-radius: 50%; background-color: rgba(0,0,0,0.6); margin-right: 8px; border: none">
				<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
			</button>
		</div>
		<div class="layout real_pics" style="height: 300px;">
			@foreach($real->images as $image)
				<div style="background-color: {{$image->placeholder_color}}; background-image: url({{$image_base_url . $image->url}});"></div>
			@endforeach
		</div>
	</div>

	@if($my_home)
		<a id="addPicturesBtn" onclick="openAddPictures()" href="javascript:void(0);" class="a-fab lg" style="z-index:10;position: absolute; bottom: -30px; right: 20px;">
			<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M9 3L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3.17L15 3H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zM12 17l1.25-2.75L16 13l-2.75-1.25L12 9l-1.25 2.75L8 13l2.75 1.25z"/></svg>
		</a>
	@endif
</div>