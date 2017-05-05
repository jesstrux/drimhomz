@foreach($houses as $house)
    <?php
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
    @include('house-item')
@endforeach

{{--{{$houses->links()}}--}}