@foreach($list as $article)
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