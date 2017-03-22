<style>
	#search_item_title{
		margin: 0;
		padding: 0;
		font-size: 1.1em;
	}
	#search_item_sub_title{
		margin: 0;
		padding: 0;
		font-size: 0.8em;
	}
	.search_item_visual{
		width: 50px; overflow: hidden;height: 50px; 
		margin-right: 10px;
		background-color: #ddd;
	}
</style>
<a href="{{$item->link}}" class="search-item layout" style="margin-bottom: 10px; color: inherit; font-family: inherit;">
	<div class="search_item_visual" style="background-color: {{ isset($item->bg) ? $item->bg : '' }}">
		@if(isset($item->img))
			<img src="{{$item->img}}" alt="" widt="100%" height="100%">
		@elseif(isset($item->cover))
			{!! $item->cover !!}
		@endif
	</div>

	<div class="layout vertical">
		<h6 id="search_item_title">{{$item->title}}</h6>
		<p id="search_item_sub_title">{{$item->sub_title}}</p>
	</div>
</a>