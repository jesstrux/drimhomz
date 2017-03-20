<?php

?>
<style>
	#projHouses{
		position: relative;
		height: 100%;
		margin: 0;
		padding: 0;
		background-color: #f3f3f3;
	}
	#projHouses .column-inner{
		position: relative;
		height: inherit;
		margin: 1px;
		max-width: calc(50% - 2px);
		min-width: calc(50% - 2px);
		height: calc(50% - 2px);
		background: #ddd;
		background-position: center;
		background-size: cover;
	}
</style>

<?php
	$houses = $project->houses()->get();
	$houses_arr = array();
?>
<div id="projHouses" class="layout wrap">
	@foreach ($houses as $key => $house)
		<div class="column-inner"
			style="background-image: url({{$house_url.'/thumbs/'.$house->image_url}})"></div>
	@endforeach

	<?php
		for($i = 0; $i < 4 - count($houses); $i++){
			echo "<div class='column-inner'></div>";
		}
	?>
</div>