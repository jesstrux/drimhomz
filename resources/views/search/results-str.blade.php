<?php
	$result_count_str = "";
	$result_count_str .= $result_count > 0 ? $result_count : "No";
	$result_count_str .= $result_count > 1 ? " results" : " result";
	$result_count_str .= " found";
?>
<style>
	a{
		color: inherit;
		font-size: inherit;
	}
	.a-divider{
		margin-top: 15px;
	}
</style>
<h5 class="a-divider">{{$result_count_str}}</h5>

@if($users->count() > 0)
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
@endif

@if($projects->count() > 0)
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
@endif

@if($houses->count() > 0)
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
@endif


@if($shops->count() > 0)
	<h5 class="a-divider">Shops</h5>
	@foreach($shops as $shop)
		@if($loop->iteration <= 3)
			<?php
				$item = new stdClass();
				$item->link = url("/shop/$shop->id");
            	$item->img = $shop_url . $shop->image_url;
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
@endif


@if($products->count() > 0)
	<h5 class="a-divider">Products</h5>
	@foreach($products as $product)
		@if($loop->iteration <= 3)
			<?php
				$item = new stdClass();
				$item->link = url("/product/$product->id");
				$item->img = $product_url . $product->image_url;
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
@endif


@if($homes->count() > 0)
	<h5 class="a-divider">Homes</h5>
	@foreach($homes as $home)
		@if($loop->iteration <= 3)
            <?php
				$item = new stdClass();
				$item->link = url("/realhomz/home/$home->id");
				$item->img = $home_url . $home->image();
				$item->title = $home->name;
				$item->sub_title = "Tshs." . number_format( $home->price , 0 );
            ?>
			@include('search.search_item')
		@else
            <?php break; ?>
		@endif
	@endforeach

	@if($homes->count() > 3)
        <?php $rem = $homes->count() - 3 ?>
		<a href="{{url('search/'.$q.'/homes')}}">View {{$rem}} more homes</a>
	@endif
@endif



@if($rentals->count() > 0)
	<h5 class="a-divider">Rentals</h5>
	@foreach($rentals as $home)
		@if($loop->iteration <= 3)
            <?php
            $item = new stdClass();
            $item->link = url("/realhomz/rental/$home->id");
            $item->img = $rental_url . $home->image();
            $item->title = $home->name;
            $item->sub_title = "Tshs." . number_format( $home->price , 0 );
            ?>
			@include('search.search_item')
		@else
            <?php break; ?>
		@endif
	@endforeach

	@if($rentals->count() > 3)
        <?php $rem = $rentals->count() - 3 ?>
		<a href="{{url('search/'.$q.'/rentals')}}">View {{$rem}} more rentals</a>
	@endif
@endif



@if($plots->count() > 0)
	<h5 class="a-divider">Plots</h5>
	@foreach($plots as $home)
		@if($loop->iteration <= 3)
            <?php
            $item = new stdClass();
            $item->link = url("/realhomz/plot/$home->id");
            $item->img = $plot_url . $home->image();
            $item->title = $home->name;
            $item->sub_title = "Tshs." . number_format( $home->price , 0 );
            ?>
			@include('search.search_item')
		@else
            <?php break; ?>
		@endif
	@endforeach

	@if($plots->count() > 3)
        <?php $rem = $plots->count() - 3 ?>
		<a href="{{url('search/'.$q.'/plots')}}">View {{$rem}} more plots</a>
	@endif
@endif