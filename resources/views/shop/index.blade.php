@extends('layouts.app')

@section('content')
    <?php
    	if(!Auth::guest())
    		$user = Auth::user();
    ?>
    <style>
		body{
			background-color: #fefefe !important;
			/*ECECEC;*/
			/*background-color: #ccc;*/
		}
	</style>

	<section class="short" style="background-color: #fff;">
	    <div class="container">
	        <div class="section-header text-center">
	            <h3 style="font-size: 3.5em">SHOP</h3>
	            <p style="font-size: 2em; margin-top: 25px;color: #777">
	                Looking for some building materials? Get started jut by checking out the shops below.
	            </p>
	        </div>
	        <br>
	    </div>
	    <hr style="border-color: #ddd; margin-bottom: 0;">
	</section>

	<div class="container" style="max-width: 800px; margin-top: 0;">
		<?php $products = $shops; ?>
		@include('shop.shops')
	</div>
@endsection