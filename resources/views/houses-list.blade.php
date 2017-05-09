@foreach($houses as $house)
    <?php
        $i = $loop->iteration;
        $ad = $random_ads[$i % 7];

        $followed_str = "FOLLOW";
        $followed_class = "";
        $house->followed = false;
        $owner = $house->owner();

        $fav_count = $house->favorites->count();
        $ltrailingS = $fav_count == 1 ? "" : "s";
        $likes_text = $fav_count . " like" . $ltrailingS;

        $comment_count = $house->comments->count();
        $ctrailingS = $comment_count == 1 ? "" : "s";
        $comments_text = $comment_count . " comment" . $ctrailingS;

        if(Auth::user())
            $house->followed = $house->followed(Auth::user()->id);

        if($house->followed){
            $followed_str = "UNFOLLOW";
            $followed_class = "followed";
        }
    ?>

    @if(isset($home_page) && $home_page && ($i == 1 || $i == 4))
        <li class="tangazo dh-card grid-item a-new-house" style="opacity: 1;">
            <div class="image">
                <a style="display: block"><img src="{{$banner_url . $ad->image_url }}" alt="{{$ad->title}}"></a>
            </div>
        </li>
    @endif

    @include('house-item')
@endforeach

{{--{{$houses->links()}}--}}