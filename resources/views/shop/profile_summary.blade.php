<style>
	.lg-followed{
		background-color: #ffa500; color: #f1eee9;
		/*pointer-events: none;*/
	}
	.lg-followed.lg-followed:hover{
		background-color: #f1a00b;color: #f1eee9; 
	}
	.lg-followed.lg-followed:focus{
		background-color: #f1a00b;color: #f1eee9;
	}
	#followBtnLg span{
		text-transform: uppercase;
	}
	#followBtnLg:not(.lg-followed) span:nth-child(2){
		display: none;
	}

	#followBtnLg.lg-followed span:nth-child(1){
		display: none;
	}
</style>

<div id="profileSummaryLg" class="col-sm-12 col-md-5 col-lg-4">
	<div id="userDetails" class="text-center">
		<div id="profilePic">
			<img src="{{asset($shop_url . $shop->image_url)}}" alt="">
		</div>
		<h3>{{$shop->name}}</h3>
		<br>
		@if($myShop)
			{{--<a href="/setupAccount" class="btn btn-default">--}}
				{{--Edit shop--}}
			{{--</a>--}}

			{{--<a href="/setupAccount" class="btn btn-default">--}}
				{{--delete shop--}}
			{{--</a>--}}
		@endif
		<!-- <hr> -->
	</div>
</div>

<div id="profileSummary" class="col-sm-12 col-md-4">
	<div id="lgDp">
		<div id="cover">
			<div id="theDp">
			</div>
		</div>
		<div id="user">
			<span id="name">{{$shop->name}}</span>

			@if(!Auth::guest())
				@if($myShop)
					<a id="followBtn" href="javascript;"
						onclick="editProduct('edit-project')">
						<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
							<path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
							<path d="M0 0h24v24H0z" fill="none"/>
						</svg>
					</a>
				@endif
			@endif
		</div>
	</div>
</div>

<script>
	function editProduct(url){
        var formdata = new FormData($("#editProduct")[0]);
        $.ajax({
              type:'POST',
              url: url,
              data: formdata,
              dataType:'json',
              async:false,
              processData: false,
              contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
        })
        .fail(function(response){
            console.log("Response!, ", response);
        })
        .always(function(){
            console.log("Action done");
        });
    }
</script>