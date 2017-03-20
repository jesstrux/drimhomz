@foreach($questions as $question)
	<div class="row full-question" id="question_12">
		<div class="col-lg-12 card no-pad question">
		    <div class="item">
	        	<div class="avatar">
	            	<img src="{{$user_url . $question->user->dp}}" width="40" alt="" />
	          	</div>
				<div class="item-text">
					<h3>{{$question->title}}</h3>
					<p><em>by</em>{{$question->user->full_name()}}</p>
				</div>
				<span class="secondary">
					<!-- Nov 9, 12:22 AM -->
					{{$question->created_at}}
				</span>
	        </div>

	        <div class="card-body">
	        	{{$question->content}}
	        </div>
		</div><!--end .col, .card -->

		<?php $answers = $question -> answers ?>
		@include('advice.answers')
	</div><!--end .row -->
@endforeach