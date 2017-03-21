<style>
	.large-text{
		font-size: 2.5em !important;
		line-height: 1.5em !important;
	}
	.product-image{
		background-color: #ddd;
		height: 150px;
		width: 150px;
	}
	a{
		color: inherit;
		font-family: inherit;
	}
</style>
@foreach($products as $product)
	<a href="{{url('/shop/').'/'.$product->id}}" class="row card no-pad" id="product_{{$product->id}}" style="margin-bottom: 30px;">
		<div class="col-lg-12">
		    <?php
				$large_text = strlen($product->name) < 80 ? "large-text" : "";
			?>
	        <div class="layout center card-body {{$large_text}}" style="font-size: 1.3em; line-height: 2em;">
	        	<div class="product-image">
	            	<!-- <img src="{{$user_url . $product->user->dp}}" width="150px" height="150px" alt="" /> -->
	          	</div>

	          	<div class="layout vertical" style="padding: 0 15px; margin-left: 20px;">
	          		<h3 class="question-title">
		          		{{$product->name}}
		          	</h3>

		          	@if($product->location)
			          	<h5>
			          		Located at: <b>{{$product->location}}</b>
			          	</h5>
		          	@endif

		        	<div class="item">
			        	<div style="width: 50px; height: 50px; overflow: hidden; border-radius: 50%;">
			            	<img src="{{$user_url . $product->user->dp}}" style="border-radius: 50%;" height="50" alt="" />
			          	</div>
						<div class="item-text">
							<p style="margin-top: 3px; margin-left: 7px;">
								<em>by {{$product->user->full_name()}} {{$product->created_at}}
								</em>
							</p>
						</div>
			        </div>
	          	</div>
	        </div>
		</div><!--end .col, .card -->
	</a><!--end .row -->

	<hr style="border-color: #e0e0e0">
@endforeach