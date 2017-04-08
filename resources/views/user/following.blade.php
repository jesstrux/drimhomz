@if(!$myProfile && is_null($house_count))
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
        {{$user->fname}} has not followed anyone yet.
    </div>
@endif

@foreach($following as $fol)
    <a href="{{url('/user/').'/'.$fol->user->id}}" class="house-card">
        <div class="image" style="background-color: #eee">
            <img src="{{asset($user_url . $fol->user->dp)}}" alt="{{$fol->user->fname}}'s dp">
        </div>
        <div class="content">
            <h3>{{$fol->user->full_name()}}</h3>
        </div>
    </a>
@endforeach
