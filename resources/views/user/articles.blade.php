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
        <a href="{{url('/advice/articles/').'/'.$fol->id}}" class="house-card">
            <div class="image" style="background-color: #eee">
        {{--            <img src="{{asset($user_url . $fol->follower->dp)}}" alt="{{$fol->follower->fname}}'s dp">--}}
                <div class="userview-image" style="background-color: #ddd"></div>
            </div>
            <div class="content">
                <h3>{{$fol->title}}</h3>
            </div>
        </a>
        @endforeach
@endif