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

	#shopImage{
		position: relative;
		/*display: inline-block;*/
		background-color: #dddddd;
		margin: auto;
		height: 240px;
		overflow: hidden;
		background-position:top center; background-size: cover;
		border-bottom: 1px solid #dddddd;
	}
</style>

<div id="profileSummaryLg" class="col-sm-12 col-md-4">
	<div id="userDetails" class="text-center" style="padding-top: 0;">
		<div id="shopImage" style="background-image: url({{asset($shop_url . $shop->image_url)}})">
		</div>

		<h3 style="padding: 10px 20px;">{{$shop->name}}</h3>
		@if($myShop)
			{{--<br>--}}
			{{--<a href="/setupAccount" class="btn btn-default">--}}
				{{--Edit shop--}}
			{{--</a>--}}

			{{--<a href="/setupAccount" class="btn btn-default">--}}
				{{--delete shop--}}
			{{--</a>--}}
		@else

			@if(Auth::guest() || !$shop->rated(Auth::user()->id))
				<button class="btn btn-primary" onclick="openRateIt(event, 'Shop', {{$shop->id}})">RATE SHOP</button>
			@endif
		@endif
		<!-- <hr> -->
	</div>
</div>

<div id="profileSummary" class="col-sm-12 col-md-4">
	<div class="layout" style="padding: 20px; padding-top: 30px; min-height: 180px; background: #fff; margin-top: -15px; border-bottom: 1px solid #dddddd; margin-bottom: 16px;">
		<div style="width: 120px; min-height: 75px; background: #dddddd; border: 1px solid #dddddd; min-width: 120px; margin-right: 20px; align-self: flex-start;">
			<img src="{{asset($shop_url . $shop->image_url)}}" alt="" width="100%">
		</div>
		<div class="flex">
			<span id="name" style="font-size: 1.6em;">{{$shop->name}}</span>
			<p>{{$shop->products->count()}} products available</p>
			<p>
				<strong>Location:</strong>

				@if($shop->street != null)
					{{$shop->street}},
				@endif

				@if($shop->town != null)
					{{$shop->town}}
				@endif

				@if($shop->country != null)
					{{$shop->country}}
				@endif
			</p>
			@if(!Auth::guest())
				@if($myShop)

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