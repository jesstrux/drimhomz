<div class="col-lg-12 answers card inset">
	<div class="show-more" style="padding: 20px 0; text-align: center; border-botto: 1px solid #ddd">
		<?php
			$no_answers = $answers->count() < 1 ? true : false;
			$btn_style = "";
			if($no_answers){
				$btn_style = "border: none; pointer-events: none !important";
			}else{
				$count_text = $answers->count();
				$trailingS = $answers->count() > 1 ? "s" : "";
			}
		?>
		@if(!$no_answers)
			<button style="{{$btn_style}}}">
				<span id="answersCount" class="show-message">{{$count_text}}</span><span class="hide-message">Hide</span><span>answer{{$trailingS}}</span>
			</button>
		@else
			<span id="answersCount" class="show-message">No</span><span> answers</span>
		@endif
	</div>

	<div class="other-answers">
		@foreach($answers as $answer)
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