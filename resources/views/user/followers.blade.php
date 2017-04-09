@if(!$myProfile && is_null($house_count))
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
        {{$user->fname}} has no followers yet.
    </div>
@endif

@foreach($followers as $fol)
    <a href="{{url('/user/').'/'.$fol->follower->id}}" class="house-card">
        <div class="image" style="background-color: #eee">
            <img src="{{asset($user_url . $fol->follower->dp)}}" alt="{{$fol->follower->fname}}'s dp">
        </div>
        <div class="content">
            <h3>{{$fol->follower->full_name()}}</h3>
        </div>
    </a>
@endforeach