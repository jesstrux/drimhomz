<div class="realPictures" style="position: relative; border-bottom: 1px solid #ddd">
	<div class="real_pics" style="height: 300px; margin-bottom: 20px; background-color: {{$real->color()}}; background-image: url({{$home_url . $real->image()}}); background-position: center; background-size: cover"></div>

	@if($my_home)
		<a onclick="openAddPictures()" href="javascript:void(0);" class="a-fab lg" style="position: absolute; bottom: -30px; right: 20px;">
			<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M9 3L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3.17L15 3H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zM12 17l1.25-2.75L16 13l-2.75-1.25L12 9l-1.25 2.75L8 13l2.75 1.25z"/></svg>
		</a>
	@endif
</div>