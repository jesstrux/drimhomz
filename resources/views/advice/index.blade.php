@extends('layouts.app')

@section('content')
    <?php
    	if(!Auth::guest())
    		$user = Auth::user();
    ?>
    <style>
		body{
			background-color: #eee !important;
			/*ECECEC;*/
			/*background-color: #ccc;*/
		}
		.tab-links{
			font-size: 1.6em;
		}
		.tab-links a{
			color: inherit;
			font-family: inherit;
		}
		.tab-links a.active{
			font-weight: bold;
			color: #444;
			pointer-events: none;
		}
		.card {
		  position: relative;
		  margin-bottom: 24px;
		  background-color: #ffffff;
		  color: #313534;
		  border-radius: 2px;
		  -webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
		  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
		}
		.card:before,
		.card:after {
		  content: " ";
		  display: table;
		}
		.card:after {
		  clear: both;
		}
		.card.no-pad{
			padding: 0;
		}
		.item, .item-text{
			display: -webkit-flex;
			display: -moz-flex;
			display: -ms-flex;
			display: -o-flex;
			display: flex;
		}
		.item{
			/*background-color: red;*/
			padding: 16px;
			-ms-align-items: center;
			align-items: center;
			border-bottom: 1px solid #ddd;
		}
		.avatar{
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: #ddd;
			overflow: hidden;
			margin-right: 16px;
		}
		.item-text{
			-webkit-flex-direction: column;
			-moz-flex-direction: column;
			-ms-flex-direction: column;
			-o-flex-direction: column;
			flex-direction: column;

			/*background-color: blue;*/

			-webkit-flex: 1px;
			-moz-flex: 1px;
			-ms-flex: 1px;
			-o-flex: 1px;
			flex: 1px;
		}
		.item-text h3{
			font-size: 16px;
			font-weight: 700;
		}
		.item-text h3, .item-text p{
			margin: 0;
			padding: 0;
		}
		.item .secondary, .item-text p{
			color: #999;
			line-height: 15px;
		}
		.item .secondary{
			font-size: 12px;
		}

		.item + .card-body{
			padding: 16px;
			padding-top: 12px;
		}


		.item + .card-body{
			font-size: 16px;
		}

		.full-question{
			overflow: hidden;
			margin-bottom: 30px;
		}

		.full-question.show-comments{
			margin-bottom: 25px;
		}

		.question{
			z-index: 2;
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.23);
			padding-bottom: 20px !important;
			margin-bottom: 0;
		}

		.inset{
			margin: 0 30px;
			width: calc(100% - 60px);
		}

		.answers{
			padding: 0;
			background-color: #f3f3f3;
			margin-bottom: 3px;
			box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1);
		}

		.full-question:not(.show-comments) .other-answers{
			display: none;
		}

		.full-question.show-comments .answers{
			/*-webkit-transform: none;
			-ms-transform: none;
			-o-transform: none;
			transform: none;*/
		}

		.item.answer{
			padding: 16px 12px;
			-ms-align-items: flex-start;
			align-items: flex-start;
		}

		.answers .item .avatar{
			margin-right: 8px;
		}

		.answers .item .secondary, .answers .item-text p{
			color: #717171;
		}

		.answers .item-text p{
			line-height: 20px;
			margin-top: 5px;
			font-size: 13px;
		}

		.answer .item-text h3{
			font-size: 16px;
			font-weight: 500;
		}

		.answers .my-answer{
			padding: 35px 25px;
			/*background-color: #f7f7f7;*/
		}

		.full-question:not(.show-comments) .my-answer{
			padding-top: 10px;
		}
		.answers .my-answer .item-text{
			-ms-align-items: flex-start;
			align-items: flex-start;
		}
		.answers .my-answer .item-text button{
			margin-top: 16px;
			-ms-align-self: flex-end;
			align-self: flex-end;
		}

		.show-more button{
			background-color: transparent;
			border-radius: 3px;
			border: 2px solid #aaa;
			color: #777;
			font-weight: bold;
			display: block;
			margin: auto;
			/*max-width: 1200px !important;*/
			/*margin-bottom: -130px;*/
		}

		.show-more button:active{
		}

		.show-more button span{
			margin: 0 3px;
			/*line-height: 15px;*/
		}

		.show-more button .hide-message{
			display: none;
		}

		.show-more button .pointer-icon{
			-webkit-transition: transform 0.25s ease-out;
			-o-transition: transform 0.25s ease-out;
			transition: transform 0.25s ease-out;
		}

		.full-question.show-comments .show-more button .hide-message{
			display: inline-block;
		}

		.full-question.show-comments .show-more button .show-message{
			display: none;
		}

		.full-question.show-comments .show-more button .pointer-icon{
			-webkit-transform: rotate(-180deg) translate3d(2px, 2px, 0);
			-ms-transform: rotate(-180deg) translate3d(2px, 2px, 0);
			-o-transform: rotate(-180deg) translate3d(2px, 2px, 0);
			transform: rotate(-180deg) translate3d(2px, 2px, 0);
		}

		.full-question.show-comments .show-more button:active{
			-webkit-transform: scaleY(0.8) translateY(-5%);
			-ms-transform: scaleY(0.8) translateY(-5%);
			-o-transform: scaleY(0.8) translateY(-5%);
			transform: scaleY(0.8) translateY(-5%);
		}

		.show-more button svg{
			width: 25px; height: 25px;
		}

		.full-question:not(.my-question) .answer:not(.my-response):not(.my-answer) form{
			display: none !important;
		}
	</style>

	<section class="short" style="background-color: #fff;margin-bottom: 50px">
	    <div class="container">
	        <div class="section-header text-center">
	            <h3 style="font-size: 3.5em">Advice</h3>
	            <!-- <p style="font-size: 2em; margin-top: 25px;color: #777">
	                Looking for advice about the kind of house you want to build, we've got you covered.
	            </p> -->
	            <br>
	            <?php
	            	$questions_active = $page == "questions" ? "active" : "";
	            	$articles_active = $page == "articles" ? "active" : "";
	            ?>
	            <h4 class="tab-links">
	            	<a href="{{url('advice/questions')}}" class="{{$questions_active}}">
	            		QUESTIONS
	            	</a> &emsp;|&emsp; 
	            	<a href="{{url('advice/articles')}}" class="{{$articles_active}}">ARTICLES</a>
	            </h4>
	        </div>
	    </div>
	</section>

	<div class="container" style="max-width: 800px; margin-top: 10px;">
		@include('advice.'.$page)
	</div>

	<script>
		$('.answer-value').on("keyup", function(){
			if($(this).val().length)
				$(this).closest('.item-text').find('button').removeAttr('disabled');
			else
				$(this).closest('.item-text').find('button').attr('disabled', 'disabled');
		});

		$('.show-more').on("click", function(){
			$(this).parents('.full-question').toggleClass('show-comments');
		});
	</script>
@endsection