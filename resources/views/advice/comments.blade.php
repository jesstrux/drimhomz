<div id="answers{{$article->id}}" class="col-lg-12 answers" style="background: transparent; box-shadow: none;">
	<div class="show-more" style="padding: 20px 0; padding-top: 0; text-align: center; border-botto: 1px solid #ddd">
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

		@if(!$no_comments)
			<button style="{{$btn_style}}}">
				<span id="commentsCount" class="show-message">{{$count_text}}</span><span class="hide-message">Hide</span><span>comment{{$trailingS}}</span>
			</button>
		@else
			<span id="commentsCount" class="show-message">No</span><span> comments</span>
		@endif
	</div>

	<div class="other-answers" style="padding: 0 16px;">
		@foreach($comments as $answer)
			<?php
				$my_answer = "";
				if(!Auth::guest() && $answer->user->id == Auth::user()->id)
					$my_answer = "my-response";
			?>
			<div id="answer{{$answer->id}}" class="item answer {{$my_answer}}" style="border-bottom: none;">
	        	<div class="avatar" style="margin-right: 0;">
	            	<img src="{{$user_url . $answer->user->dp}}" width="40" alt="" />
	          	</div>
				<div class="item-text">
					<h3>{{$answer->user->full_name()}}
						<span style="display: block; margin-top: 2px;margin-bottom: 8px; font-size: 0.9em; color: #999">
							{{$answer->created_at->diffForHumans()}}
						</span>
					</h3>
					<p style="margin-top: 0; font-size: 1em">
						{{$answer->content}}
					</p>
				</div>

				<span class="secondary" styl="float: right">
					<form style="display: inline-block" method="POST" id="removeAnswer{{$answer->id}}" action="/removeComment" onsubmit="removeAnswer(event, '{{$answer->id}}')">
						{{csrf_field()}}
							<input name="id" type="hidden" value="{{$answer->id}}">
						<button class="btn" type="submit">
							<i class="fa fa-trash"></i>
						</button>
					</form>
				</span>
	        </div>
	    @endforeach
	</div>
    <div class="my-answer item answer" style="border-bottom: none;">
        @if(Auth::check() && $user)
			<div class="avatar">
				<img src="{{$user_url . $user->dp}}" width="40" alt="" />
				<input type="hidden" value="{{Auth::user()->fname ." " . Auth::user()->lname}}">
			</div>
			<form method="POST" class="item-text" id="submitAnswer{{$article->id}}" action="/submitArticleComment" onsubmit="submitAnswer(event, '{{$article->id}}')">
				{{csrf_field()}}
				<input id="userId" name="user_id" type="hidden" value="{{Auth::user()->id}}">
				<input id="questionId" name="article_id" type="hidden" value="{{$article->id}}">
				<textarea name="content" class="form-control autosize answer-value" rows="3" placeholder="Your comment..." required="true" onkeyup="activateSubmitBtn(event)"></textarea>
				<button class="btn btn-primary" disabled type="submit">&nbsp;SUBMIT&nbsp;</button>
			</form>
        @else
        	<p>
        		<center>
        			<a href="{{URL('/login')}}">
        				LOGIN
        			</a> TO COMMENT
        		</center>
        	</p>
        @endif
    </div>
</div>

<script>
	var new_comment_form;
	var dp_src = "";
	var user_name = "";
	var the_btn, the_area, the_val;

	function submitAnswer(e, id){
		e.preventDefault();
		id = parseInt(id);

		showLoading();

		new_comment_form = $("#submitAnswer"+id);
		var formdata = new FormData(new_comment_form[0]);

		var parent = new_comment_form.closest('.my-answer');
		dp_src = parent.find(".avatar img").attr("src");
		user_name = parent.find(".avatar input").val();
		the_btn = new_comment_form.find("button");
		the_area = new_comment_form.find("textarea");
		the_val = the_area.val();

		the_area.val("");
		the_btn.attr("disabled", "disabled");

		$.ajax({
			type:'POST',
			url: new_comment_form.attr("action"),
			data: formdata,
			dataType:'json',
			async:false,
			processData: false,
			contentType: false
		})
		.done(function(response){
			if(response.success){
				showToast("success", "Comment sent");
				var answer = response.answer;
				var new_answer =
				'<div id="answer'+answer.id+'" class="item answer my-response" style="border-bottom: none;"> ' +
					'<div class="avatar" style="margin-right: 0;"> <img src="'+dp_src+'" width="40" alt="" /> </div> ' +
					'<div class="item-text"> ' +
					'<h3>'+user_name+'' +
					'<span style="display: block; margin-top: 2px;margin-bottom: 8px; font-size: 0.9em; color: #999">now</span></h3>'+
					' <p style="margin-top: 0; font-size: 1em"> '+answer.content+' </p> </div>' +
                	'<span class="secondary" style="float: right;">' +
						'<form style="display: inline-block" method="POST" id="removeAnswer'+answer.id+'" action="/removeComment" onsubmit="removeAnswer(event, '+answer.id+')">' +
						''+_token+'<input name="id" type="hidden" value="'+answer.id+'"> ' +
						'<button class="btn" type="submit"> <i class="fa fa-trash"></i> </button> </form>' +
					'</span>' +
				'</div>';
				$("#answers"+id).find(".other-answers").append($(new_answer));
				console.log(answer, $(new_answer));
			}else{
				showToast("error", response.msg);
				the_btn.removeAttr("disabled");
				the_area.val(the_val);
			}
		})
		.fail(function(response){
			showToast("error", "Unknown Error occured");
			the_btn.removeAttr("disabled");
			the_area.val(the_val);
		})
		.always(function(){
			hideLoading();
		});
	}

	function activateSubmitBtn(e){
		if(!e)
			return;

		var el = $(e.target);
		var btn = el.closest("form").find("button");

		if(el.val().length > 0)
			btn.removeAttr("disabled");
		else
			btn.attr("disabled", "disabled");
	}


	function removeAnswer(e, id){
		e.preventDefault();
		id = parseInt(id);

		showLoading();

		var remove_answer_form = $("#removeAnswer"+id);
		var formdata = new FormData(remove_answer_form[0]);

		$.ajax({
			type:'POST',
			url: remove_answer_form.attr("action"),
			data: formdata,
			dataType:'json',
			async:false,
			processData: false,
			contentType: false
		})
		.done(function(response){
			if(response.success){
				showToast("success", "Comment deleted");
				$("#answer"+id).remove();
			}else{
				showToast("error", response.msg);
			}
		})
		.fail(function(response){
			showToast("error", "Unknown Error occured");
		})
		.always(function(){
			hideLoading();
		});
	}
</script>