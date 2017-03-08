@if(!$myProfile && is_null($house_count))
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
        {{$user->fname}} has no followers yet.
    </div>
@endif

@foreach($followers as $fol)
    <div class="house-card">
        <div class="image" style="background-color: #eee">
            <img src="{{asset($user_url . $fol->follower->dp)}}" alt="{{$fol->follower->fname}}'s dp">
        </div>
        <div class="content">
            <h3><a href="/user/{{$fol->follower->id}}" style="color: inherit;">{{$fol->follower->full_name()}}</a></h3>
        </div>
    </div>
@endforeach