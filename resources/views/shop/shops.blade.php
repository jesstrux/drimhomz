<style>
	.big-outer{
		margin-bottom: 10px;
		margin-top: 0;
	}
	.large-text{
		font-size: 2.5em !important;
		line-height: 1.5em !important;
	}

	.expert-wrapper{
		/*background-color: #00b3ee;*/
	}

	.expert-image{
		background-color: #ddd;
		min-height: 110px;
		width: 150px;
	}

	.expert-info{
		padding: 0 15px;
		margin-left: 5px;
		width: 100%;
		box-shadow: none !important;
	}

	.expert-info h3{
		color: #333;
		font-size: 2.1rem;
		margin: 0; margin-bottom: 10px;
	}

	.expert-activity{
		font-size: 1em;
		/*font-weight: bold;*/
		margin: 0;
	}

	@media only screen and (max-width: 760px) {
		.expert-image{
			min-height: 40px;
			width: 70px;
		}

		.expert-info h3{
			margin: 0; margin-bottom: 4px;
		}

		.expert-activity{
			margin-top: -5px;
		}
	}
	a{
		color: inherit !important;
		font-family: inherit;
	}
	a.card{
		text-decoration: none !important;
	}
</style>

@if($products->count() < 1)
	<div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">There are no shops available.</div>
@endif

@foreach($products as $product)
	<a href="{{url('/shop/'.$product->id)}}" class="big-outer" id="shop_{{$product->id}}">
		<div>
			<?php
				$full_name = $product->user->fname . " " . $product->user->lname;
			?>

			<div class="expert-wrapper layout">
				<div class="expert-image" style="align-self: flex-start;">
					<img src="{{$shop_url . $product->image_url}}" width="100%" alt="" />
				</div>

				<div class="expert-info layout vertical" style="box-shadow: none !important">
					<h3>
						{{$product->name}}
					</h3>

                    <span style="display: block">
                        Seller:
                        <span style="font-weight: bold;">
                            {{$full_name}} - {{$product->user->phone}}
                        </span>
                    </span>
				</div>
			</div>
		</div><!--end .col, .card -->
	</a><!--end .row -->
	@if($loop->iteration != $products->count())
		<hr style="border-color: #e0e0e0">
	@else
		<br>
	@endif
@endforeach