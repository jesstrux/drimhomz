@if($reviews_count < 1)
    @if(!$myProfile)
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            {{$user->fname}} has no reviews yet.
        </div>
    @else
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            You have no reviews.
        </div>
    @endif
@endif


@if($reviews_count > 0)
        @foreach($reviews as $fol)
        <a href="{{url('/user/').'/'.$fol->user->id}}" class="house-card" style="text-align: center;">
            <div style="padding: 20px 0; padding-bottom: 5px;">
                <img style="background-color: #eee;height: 70px !important; width: 70px !important; border-radius: 50%" src="{{asset($user_url . $fol->user->dp)}}" alt="{{$fol->user->fname}}'s dp">

                <p style="margin-top: 10px;">{{$fol->user->fname . ' ' . $fol->user->lname}}</p>
            </div>
            <div class="content">
                <div class="user-rating" my-rating="{{$fol->rating}}" style="margin: 10px auto;"></div>
                <span class="social-stuff">
                    {{$fol->comment}}
                </span>
            </div>
        </a>
        @endforeach
    @else
@endif

@if(!Auth::guest() && Auth::user()->id != $user->id
                    && !$user->rated(Auth::user()->id))
    <button class="a-fab lg" onclick="openRateExpert()" style="position: fixed; right: 20px; bottom: 20px;">
        <i class="fa fa-plus"></i>
    </button>
@endif

<script src="{{asset('js/jquery.rateyo.min.js')}}"></script>

@if(!Auth::guest() && Auth::user()->id != $user->id
                    && !$user->rated(Auth::user()->id))
    <?php
    $expert = $user;
    ?>
    @include('expert.rate_expert')
@endif

<script>
    $(".user-rating").each(function(){
        var rating = $(this).attr('my-rating');

        $(this).rateYo({
            readOnly: true,
            maxValue: 5,
            numStars: 5,
            halfStar: true,
            starWidth: "20px",
            rating: rating
        });
    });
</script>