<style>
	#newPictureOuter{
		background-image: none;
		background-color: rgba(0,0,0,0.1);
	}
	#newPictureOuter .cust-modal-content{
		box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2);
		padding: 22px 26px;
		padding-top: 8px;border-radius: 6px;
		width: 300px;
	}

	#newPictureOuter #dpOuter:not(.saving) .layout{
		opacity: 0 !important;
		pointer-events: none !important;
	}

	#newPictureOuter #temp-dp{
		width: 120px;
		height: 120px;
		border-radius: 50%;
		background-color: #ddd;
		margin-top: 20px;
	}
	@media only screen and (max-width: 760px) {
		#newPictureOuter .cust-modal-content{
			padding-top: 22px;
			border-radius: 0;
			width: 100vw;
			height: calc(100vh - 48px);
			background-color: #000;
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
			-ms-align-items: center;
			align-items: center;
			justify-content: center;
			position: relative;
		}

		#newPictureOuter #temp-dp{
			margin-top: 0;
			border-radius: 0;
			width: 100vw !important;
			height: auto !important;
		}
	}
</style>
<div id="newPictureOuter" class="cust-modal ope">
	<div class="hidden visible-xs cust-modal-toolbar no-shadow" style="z-index: 2; background: #000;">
		<div class="layout center" style="height: 60px; color: #fff">
			<button class="layout center for-mob" style="padding: 0 9px;background: transparent; border: none;" onclick="closeNewPicture()">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="38" height="38" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
			</button>

			<h5 class="flex" style="font-size: 23px; margin: 0; margin-left: 8px;">Profile Picture</h5>

			@if(isset($myProfile) && $myProfile)
				<form id="newPicture" enctype="multipart/form-data" role="form" method="POST" action="{{ url('save-dp') }}" onsubmit="savePicture(event, false)">
					<h3 class="hidden-xs" style="margin-top: 15px;">Profile picture</h3>
					<input type="hidden" name="user_id" value="{{$user->id}}">
					<input type="file" id="filePicker" name="dp" class="hidden" onchange="fileChosen()" accept="image/*">
					{{csrf_field()}}
				</form>

				<label for="filePicker" class="btn layout center-center" style="min-height:0; height: auto;margin: 0 5px; display: inline-block;background-color: transparent; padding: 6px 4px;padding-bottom: 0; border-color: transparent">
					<svg fill="#fff" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path d="M9 3L7.17 5H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3.17L15 3H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zM12 17l1.25-2.75L16 13l-2.75-1.25L12 9l-1.25 2.75L8 13l2.75 1.25z"/></svg>
				</label>

				@if($user->dp != null && $user->dp != "def.png")
					<form id="removePicture" method="POST" action="{{ url('save-dp') }}" onsubmit="savePicture(event, true)">
						<input type="hidden" name="user_id" value="{{$user->id}}">
						{{csrf_field()}}
						<button class="btn layout center-center save-new-project" style="min-height:0; height: auto;margin: 0 5px; display: inline-block; background-color: transparent; padding: 6px 4px;padding-bottom: 0; border-color: transparent">
							<svg xmlns="http://www.w3.org/2000/svg" fill="#f00" width="30" height="30" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
						</button>
					</form>
				@endif
				<div style="width: 10px;"></div>
			@endif
		</div>
	</div>

	<div class="cust-modal-content" style="position: relative; text-align: center;">
		<div id="dpOuter" style="position: relative; margin-bottom: 85px; display: inline-block; overflo: hidden;">
			<img src="{{$user_url . $user->dp}}" alt="{{$user->fname}}'s picture" id="temp-dp" class="a-dp">

			<div class="layout center-center" style="background-color: rgba(5,5,5,0.5); position: absolute; top: 0; left: 0;width: 100%; height: 100%;">
				<img src="{{asset("images/loading.gif")}}" alt="loading..." style="width: 60px;">
			</div>
		</div>

		<button class="closer hidden-xs" onclick="closeNewPicture()">
			<svg fill="#aaa" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
		</button>
	</div>
</div>

<script>
	var org_pic, tempImage, pic_animation, picCard, picBox, fromElBox;
	function closeNewPicture() {
		$("#newPictureOuter").removeClass("open");
		$("#newPictureTitle").val("");
		$("#newPictureOuter #temp-dp").css({"opacity": 1});

		var translateX = (picBox.left + (picBox.width / 2)) - (fromElBox.left + (fromElBox.width / 2));
		var translateY = (picBox.top + (picBox.height / 2)) - (fromElBox.top + (fromElBox.height / 2));
		var translate = 'translate(' + translateX + 'px,' + translateY + 'px)';
		var size = Math.max(fromElBox.width + Math.abs(translateX) * 2, fromElBox.height + Math.abs(translateY) * 2);
		var diameter = Math.sqrt(2 * size * size);
		var scaleX = diameter / fromElBox.width;
		var scaleY = diameter / fromElBox.height;
		var scale = 'scale(' + scaleX + ',' + scaleY + ')';
		var transform = scale + " " + translate;

//		fromEl.style.borderRadius = "0";
		fromEl.style.transformOrigin = picCard.style.webkitTransformOrigin = "50% 50%";

		fromEl_animation = fromEl.animate([
			{opacity: 0, transform: translate + "scale(0)"},
			{opacity: 1.0, transform: "none"}
		], {
			duration: 180,
			fill: 'forwards'
		});

		fromEl_animation.onfinish = function() {
//			fromEl.style.borderRadius = "50%";
		};
	}

	function openNewPicture(e) {
		$("#newPictureOuter").addClass("open");
		$("#newPictureTitle").focus();
		$("body").addClass("locked");

		picCard = $("#newPictureOuter #temp-dp").get(0);
		$("#newPictureOuter #temp-dp").css({"opacity": 0});
		picBox = picCard.getBoundingClientRect();
		fromEl = e.currentTarget;
		fromElBox = fromEl.getBoundingClientRect();

		var translateX = (fromElBox.left + (fromElBox.width / 2)) - (picBox.left + (picBox.width / 2));
		var translateY = (fromElBox.top + (fromElBox.height / 2)) - (picBox.top + (picBox.height / 2));
		var translate = 'translate(' + translateX + 'px,' + translateY + 'px)';
		var size = Math.max(picBox.width + Math.abs(translateX) * 2, picBox.height + Math.abs(translateY) * 2);
		var diameter = Math.sqrt(2 * size * size);
		var scaleX = diameter / picBox.width;
		var scaleY = diameter / picBox.height;
		var scale = 'scale(' + scaleX + ',' + scaleY + ')';
		var transform = scale + " " + translate;

		picCard.style.transformOrigin = picCard.style.webkitTransformOrigin = "50% 50%";
		picCard.style.borderRadius = Math.max(picBox.width, picBox.height)+"px";

		picCard.style.opacity = 1;
		pic_animation = picCard.animate([
			{opacity: 0, transform: translate + "scale(0)"},
			{opacity: 1.0, transform: "none"}
		], {
			duration: 180,
			fill: 'forwards'
		});

		pic_animation.onfinish = function() {
			picCard.style.borderRadius = "0";
		};
	}

	function fileChosen(files){
		if(event.target.files.length){
			var file = event.target.files[0];

			if(file.type.match(/image.*/)) {
				console.log('An image has been loaded');
				var reader = new FileReader();
				reader.onload = function (readerEvent) {
					tempImage = readerEvent.target.result;
//					$(".a-dp").attr('src', tempImage);

					savePicture();
				};
				reader.readAsDataURL(file);
			}
			else{
				showToast("error", "Please choose an image!");
			}
		}
	}

	function savePicture(e, remove){
		if(e){
			e.preventDefault();
		}

		var form = $("#newPicture")[0];
//		if(remove){
//			tempImage = user_base_url + "def.png";
//			$("#temp-dp").attr('src', tempImage);
//		}

		$("#newPictureOuter #dpOuter").addClass("saving");
//        return;

		$.ajax({
			type:'POST',
			url: "/saveDp",
			data:new FormData(form),
			dataType:'json',
			async:false,
			processData: false,
			contentType: false
		})
		.done(function(response){
//			document.write(response.responseText);
//			console.log("Response!, ", response);
			if(response.success){
				var uri = user_base_url + response.picture_url;

				$(".a-dp").attr('src', uri);
				$(".a-dp-bg").css("background-image", "url("+uri+")");
				showToast("success", response.msg);
			}
			else{
				showToast("error", response.msg);
			}
		})
		.fail(function(response){
//			document.write(response.responseText);
//			console.log("Response!, ", response);
		})
		.always(function(){
			console.log("Action done");
			$("#newPictureOuter #dpOuter").removeClass("saving");
		});
	}
</script>