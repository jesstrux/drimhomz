<div class="col-lg-12 answers card inset">
	<?php
	$no_comments = $comments->count() < 1 ? true : false;
	$btn_style = "";
	if($no_comments){
		$btn_style = "border: none; pointer-events: none !important";
	}else{
		$count_text = $comments->count();
		$trailingS = $comments->count() > 1 ? "s" : "";
	}
	?>
	<div class="show-more" style="padding: 20px 0; text-align: center; border-botto: 1px solid #ddd">
		@if(!$no_comments)
			<button style="{{$btn_style}}}">
				<span id="commentsCount" class="show-message">{{$count_text}}</span><span class="hide-message">Hide</span><span>comment{{$trailingS}}</span>
			</button>
		@else
			<span id="commentsCount" class="show-message">No</span><span> comments</span>
		@endif
	</div>

	<div class="other-answers">
		@foreach($comments as $answer)
			<div class="item answer">
	        	<div class="avatar">
	            	<img src="{{$user_url . $answer->user->dp}}" width="40" alt="" />
	          	</div>
				<div class="item-text">
					<h3>{{$answer->user->full_name()}} <span class="secondary" style="float: right">{{$answer->created_at->diffForHumans()}}</span></h3>
					<p>
						{{$answer->content}}
					</p>
				</div>
	        </div>
	    @endforeach
	</div>
    <div class="my-answer item answer">
        @if($user)
        	<div class="avatar">
            	<img src="{{$user_url . $user->dp}}" width="40" alt="" />
          	</div>
          	<div class="item-text">
          		<textarea name="answer" id="compose-answer-12" class="form-control autosize answer-value" rows="3" placeholder="Your Answer..." required="true"></textarea>
          		<button class="btn btn-primary" disabled>&nbsp;SUBMIT&nbsp;</button>
          	</div>
        @else
        	<p>
        		<center>
        			<a href="URL('/login')">
        				LOGIN
        			</a> TO COMMENT
        		</center>
        	</p>
        @endif
    </div>
</div>