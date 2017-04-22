@if(is_null($articles_count))
    @if(!$myProfile)
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            {{$user->fname}} has not written any articles yet.
        </div>
    @else
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            You have no articles.
        </div>
    @endif
@endif


@if($articles_count > 0)
        @foreach($articles as $article)
       <div class="house-card a-house-item">
        <a href="{{url('/advice/articles/#article_').$article->id}}" style="cursor: pointer;" >
            <div class="image" style="background-color: #999">
                <img src="{{asset($article_img_url . $article->image())}}" alt="{{$article->title}}">
            </div>
        </a>
        <div class="content">
            <h3>{{$article->title}}</h3>
            {{--<span class="social-stuff">--}}
            {{--<span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}--}}
            {{--</span>--}}
        </div>
           </div>

        @endforeach
@endif
