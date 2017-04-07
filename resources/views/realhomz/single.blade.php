@extends('layouts.app')

@section('content')
	<?php
		$my_home = false;

		if(!Auth::guest()){
			$user = Auth::user();
			$my_home = $user->id == $real->user_id;
		}

		$my_home_class = $my_home ? "my-home" : "";
	?>
	@include('realhomz.single_'.$page)
@endsection