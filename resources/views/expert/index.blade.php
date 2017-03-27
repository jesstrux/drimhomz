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
	            <h3 style="font-size: 3.5em">EXPERTS</h3>
	            <p style="font-size: 2em; margin-top: 25px;color: #777">
	                Looking for some consultation or advice before you make a decision, checkout an expert below.
	            </p>
	        </div>
	        <br>
	    </div>
	    <hr style="border-color: #ddd; margin-bottom: 0;">
	</section>

	<div class="container" style="max-width: 800px; margin-top: 10px;">
		<?php $products = $experts; ?>
		@include('expert.experts')
	</div>
@endsection