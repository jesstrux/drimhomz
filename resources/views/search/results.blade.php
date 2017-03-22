@extends('layouts.app')

@section('content')
	<?php
		$result_count_str = "";
		$result_count_str .= $result_count > 0 ? $result_count : "No";
		$result_count_str .= $result_count > 1 ? " results" : " result";
		$result_count_str .= " found";
	?>
	<style>
		body{
			background-color: #eee;
		}
		a{
			color: inherit;
			font-size: inherit;
		}

		.content{
			width:100%;max-width: 700px;
			margin: 30px auto;
		}

		#categoryResults .dh-card{
			padding: 30px; 
		}

		#categoryResults .search-item{
			margin-bottom: 30px !important;
		}

		#categoryResults .search-item .search_item_visual{
			height: 100px !important;
			width: 100px !important;
			margin-right: 40px !important;
		}

		#categoryResults #search_item_title{
			margin-top: 10px !important;
			margin-bottom: 6px !important;
			font-size: 1.8em !important;
		}
		
		#categoryResults #search_item_sub_title{
			font-size: 1.4em !important;
		}

		#categoryResults .a-divider{
			font-size: 1.4em !important;
			margin-bottom: 20px;
		}

		#categoryResults .a-divider:first-child{
			font-size: 1.8em !important;
			margin-bottom: 30px !important;
		}
	</style>

	<div id="categoryResults" class="container">
		<div class="content">
			<h5 class="a-divider">{{$result_count_str}}</h5>
		
			@if($users->count() > 0)
				<div class="dh-card">
					<h5 class="a-divider">People</h5>
					@foreach($users as $user)
						@if($loop->iteration <= 3)
							<?php
								$item = new stdClass();
								$item->img = $user_url . $user->dp;
								$item->link = url("/user/$user->id");
								$item->title = $user->fname . " " . $user->lname;
								$item->sub_title = $user->role;
							?>
							@include('search.search_item')
						@else
							<?php break; ?>
						@endif
					@endforeach	

					@if($users->count() > 3)
						<?php $rem = $users->count() - 3 ?>
						<a href="{{url('search/'.$q.'/users')}}">View {{$rem}} more users</a>
					@endif
				</div>
			@endif

			@if($projects->count() > 0)
				<div class="dh-card">
					<h5 class="a-divider">Projects</h5>
					@foreach($projects as $project)
						@if($loop->iteration <= 3)
							<?php
								$item = new stdClass();
								$item->link = url("/project/$project->id");
								$item->cover = $project->cover();
								$item->title = $project->title;
								$item->sub_title = $project->user->fname ." ". $project->user->lname;
							?>
							@include('search.search_item')
						@else
							<?php break; ?>
						@endif
					@endforeach

					@if($projects->count() > 3)
						<?php $rem = $projects->count() - 3 ?>
						<a href="{{url('search/'.$q.'/projects')}}">View {{$rem}} more projects</a>
					@endif
				</div>
			@endif

			@if($houses->count() > 0)
				<div class="dh-card">
					<h5 class="a-divider">Houses</h5>
					@foreach($houses as $house)
						@if($loop->iteration <= 3)
							<?php
								$item = new stdClass();
								$item->bg = $house->placeholder_color;
								$item->link = url("/house/$house->id");
								$item->img = $house_url . "thumbs/" . $house->image_url;
								$item->title = $house->title;
								$item->sub_title = $house->owner()->fname ." ". $house->owner()->lname;
							?>
							@include('search.search_item')
						@else
							<?php break; ?>
						@endif
					@endforeach

					@if($houses->count() > 3)
						<?php $rem = $houses->count() - 3 ?>
						<a href="{{url('search/'.$q.'/houses')}}">View {{$rem}} more houses</a>
					@endif
				</div>
			@endif


			@if($shops->count() > 0)
				<div class="dh-card">
					<h5 class="a-divider">Shops</h5>
					@foreach($shops as $shop)
						@if($loop->iteration <= 3)
							<?php
								$item = new stdClass();
								$item->link = url("/shop/$shop->id");
								$item->img = $res_url . "/shops/thumbs/" . $shop->image_url;
								$item->title = $shop->name;
								$item->sub_title = $shop->user->fname ." ". $shop->user->lname;
							?>
							@include('search.search_item')
						@else
							<?php break; ?>
						@endif
					@endforeach

					@if($shops->count() > 3)
						<?php $rem = $shops->count() - 3 ?>
						<a href="{{url('search/'.$q.'/shops')}}">View {{$rem}} more shops</a>
					@endif
				</div>
			@endif


			@if($products->count() > 0)
				<div class="dh-card">
					<h5 class="a-divider">Products</h5>
					@foreach($products as $product)
						@if($loop->iteration <= 3)
							<?php
								$item = new stdClass();
								$item->link = url("/product/$product->id");
								$item->img = $res_url . "/products/thumbs/" . $product->image_url;
								$item->title = $product->name;
								$item->sub_title = $product->shop->name;
							?>
							@include('search.search_item')
						@else
							<?php break; ?>
						@endif
					@endforeach

					@if($products->count() > 3)
						<?php $rem = $products->count() - 3 ?>
						<a href="{{url('search/'.$q.'/products')}}">View {{$rem}} more products</a>
					@endif
				</div>
			@endif
		</div>
	</div>
@endsection