<style>
	.large-text{
		font-size: 2.5em !important;
		line-height: 1.5em !important;
	}
	.expert-image{
		background-color: #ddd;
		min-height: 110px;
		width: 150px;
	}
	@media only screen and (max-width: 760px) {
		.expert-image{
			min-height: 40px;
			width: 70px;
		}
	}
</style>

@foreach($articles as $article)
	<?php
		$my_question = "";
		if(!Auth::guest() && $article->user->id == Auth::user()->id)
			$my_question = "my-question";
	?><div id="article_{{$article->id}}" style="margin-bottom: 60px"></div>
	<div class="row full-question {{$my_question}}" id="article{{$article->id}}">
		<div class="col-lg-12 card no-pad question">
		    <div class="item">
	        	<div class="avatar">
	            	<img src="{{$user_url . $article->user->dp}}" width="40" alt="" />
	          	</div>

				<div class="house-card a-house-item">
					<div style="cursor: pointer;">
						<div class="image" style="background-color: #999">

							<div class="userview-image" style="background-image: url({{$article_img_url .'thumbs/'. $article->image()}})"></div>
						</div>
					</div>
				</div>
				<div class="item-text">
					<h3 class="question-title">{{$article->title}}</h3>
					<p style="margin-top: 3px;">
						<em>by {{$article->user->full_name()}}</em>
					</p>
				</div>
				<span class="secondary">
					{{$article->created_at->diffForHumans()}}
				</span>
	        </div>

	        <?php
				$large_text = strlen($article->content) < 80 ? "large-text" : "";
			?>
	        <div class="card-body {{$large_text}}" style="font-size: 1.3em; line-height: 2em;">
	        	{{str_limit($article->content, 225)}}

		        {{--<a href="{{url('advice/article/'.$article->slug)}}">--}}
			        {{--@if(strlen($article->content) > 225)--}}
				        {{--Read more--}}
			        {{--@else--}}
				        {{--View Article--}}
			        {{--@endif--}}
		        {{--</a>--}}
	        </div>
		</div><!--end .col, .card -->

		<?php $comments = $article -> comments ?>
		@include('advice.comments')
	</div><!--end .row -->
@endforeach