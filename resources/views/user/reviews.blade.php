<div id="usersSubsList" class="layout wrap" style="margin-bottom: 10px;">
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

    @include('user.reviews-list')
</div>

@if($following_count > $per_page)
    <button id="userMoreBtn" class="btn btn-default btn-block" style="padding: 10px 0;" onclick="getMore()">LOAD MORE</button>
@endif

<script src="{{asset('js/jquery.rateyo.min.js')}}"></script>

@if(!Auth::guest() && Auth::user()->id != $user->id
                    && !$user->rated(Auth::user()->id))
    <button class="a-fab lg" onclick="openRateIt(event, 'Expert', {{$user->id}})" style="position: fixed; right: 20px; bottom: 20px;">
        <i class="fa fa-plus"></i>
    </button>
@endif

@if(!Auth::guest() && Auth::user()->id != $user->id
                    && !$user->rated(Auth::user()->id))
    @include('rating.rate_it')
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