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
        @foreach($articles as $fol)

       <div class="house-card a-house-item">
        <a href="{{url('/advice/articles/#question_').$fol->id}}" style="cursor: pointer;" >
            <div class="image" style="background-color: #eee">
                {{--<img src="{{asset($house_url . $house->image_url)}}" alt="{{$house->title}}">--}}
                <div class="userview-image" style="background-color: #ddd"></div>
            </div>
        </a>
        <div class="content">
            <h3>{{$fol->title}}</h3>
            {{--<span class="social-stuff">--}}
            {{--<span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}--}}
            {{--</span>--}}
        </div>
           </div>

        @endforeach
@endif
