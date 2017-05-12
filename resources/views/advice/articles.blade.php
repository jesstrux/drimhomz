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

	.article-thumb{
		display: inline-block;
		margin-right: 16px;width: 200px;
		shape-outside: inset(100px 100px 100px 100px 10px);
		float: left;
	}

	@media only screen and (max-width: 760px) {
		.expert-image{
			min-height: 40px;
			width: 70px;
		}

		.article-thumb{
			width: 120px;
			/*float: right;*/
		}

		.full-question{
			margin-top: -25px;
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
			<h3 class="question-title" style="padding: 0 30px; padding-top: 34px;">{{$article->title}}</h3>
            <?php
            $large_text = strlen($article->content) < 80 ? "large-text" : "article";
            ?>
			{{--<div class="card-body  {{$large_text}}" style="font-size: 1.3em; line-height: 2em;">--}}
			{{--{{str_limit($article->content, 225)}} --}}
			{{--<p>{{$article->content}}</p>--}}

			{{--<a href="{{url('advice/article/'.$article->id)}}">--}}
			{{--@if(strlen($article->content) > 225)--}}
			{{--<a href="#"><small>Read more</small></a>--}}
			{{--@else--}}
			{{--<small>View Article</small>--}}
			{{--@endif--}}
			{{--</a>--}}
			<div class="card-body {{$large_text}}" style="padding:20px 30px; padding-bottom: 15px; font-size: 1.3em; line-height: 2em;">
				<img src="{{$article_img_url . $article->image()}}" alt="" class="article-thumb">

				@if(strlen($article->content) > 225)
					<p>{{$article->content}}</p>
					<a href="#"><small>Read more</small></a>
				@else
					<p>{{$article->content}}</p>
				@endif

				<span style="font-size: 13px; font-family: Verdana, Geneva, sans-serif; display: block">
					By:
					<a href="{{url("/user/" . $article->user->id)}}" class="user-link" data-user-id="{{$article->user->id}}" style="font-weight: bold">
						{{$article->user->full_name()}}
					</a>,
					<span style="color: #888">
						{{$article->created_at->diffForHumans()}}
					</span>
				</span>
			</div>

			<div style="padding: 10px 24px;">
				<hr>
				<h4 style="margin-top: 35px;">Comments:</h4>
			</div>

            <?php $comments = $article -> comments ?>
			@include('advice.comments')
		</div>
	</div><!--end .row -->
@endforeach
<script src="{{asset('js/jQuery.curtail.min.js')}}"></script>
<script>
    $('.article').curtail({
        limit: 140,
        ellipsis: '...',
        toggle: true,
        text: ['Read less', 'Read more...']

    });


</script>


{{$articles->links()}}
