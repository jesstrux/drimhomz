<style>
	.large-text{
		font-size: 2.5em !important;
		line-height: 1.5em !important;
	}
</style>
@foreach($articles as $question)
	<div class="row full-question" id="question_{{$question->id}}">
		<div class="col-lg-12 card no-pad question">
		    <div class="item">
	        	<div class="avatar">
	            	<img src="{{$user_url . $question->user->dp}}" width="40" alt="" />
	          	</div>
				<div class="item-text">
					<h3 class="question-title">{{$question->title}}</h3>
					<p style="margin-top: 3px;">
						<em>by {{$question->user->full_name()}}</em>
					</p>
				</div>
				<span class="secondary">
					<!-- Nov 9, 12:22 AM -->
					{{$question->created_at}}
				</span>
	        </div>

	        <?php
				$large_text = strlen($question->content) < 80 ? "large-text" : "";
			?>
	        <div class="card-body {{$large_text}}" style="font-size: 1.3em; line-height: 2em;">
	        	{{$question->content}}
	        </div>
		</div><!--end .col, .card -->

		<?php $comments = $question -> comments ?>
		@include('advice.comments')
	</div><!--end .row -->
@endforeach