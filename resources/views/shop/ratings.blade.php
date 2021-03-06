@if($shop->ratings->count() < 1)
    <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
        This shop has no reviews yet.
    </div>
@endif

@foreach($shop->ratings as $fol)
    <div href="{{url('/user/').'/'.$fol->user->id}}" class="house-card" style="text-align: center;">
        <div style="padding: 20px 0; padding-bottom: 5px;">
            <img style="background-color: #eee;height: 70px !important; width: 70px !important; border-radius: 50%" src="{{asset($user_url . $fol->user->dp)}}" alt="{{$fol->user->fname}}'s dp">

            <p style="margin-top: 10px;">{{$fol->user->fname . ' ' . $fol->user->lname}}</p>
        </div>
        <div class="content">
            <div class="user-rating" my-rating="{{$fol->rating->rating}}" style="margin: 10px auto;"></div>
            <span class="social-stuff">
                    {{$fol->rating->comment}}
                </span>
        </div>
    </div>
@endforeach