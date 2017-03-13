@if(!$myProfile && is_null($house_count))
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
        {{$user->fname}} has not followed anyone yet.
    </div>
@endif

@foreach($following as $fol)
    <div class="house-card">
        <div class="image" style="background-color: #eee">
            <img src="{{asset($user_url . $fol->user->dp)}}" alt="{{$fol->user->fname}}'s dp">
        </div>
        <div class="content">
            <h3><a href="/user/{{$fol->user->id}}" style="color: inherit;">{{$fol->user->full_name()}}</a></h3>
        </div>
    </div>
@endforeach
