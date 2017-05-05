@foreach($houses as $house)
    <?php
    $fav_count = $house->favorites->count();
    $trailingS = $fav_count == 1 ? "" : "s";
    $likes_text = $fav_count. " like".$trailingS;

    $comment_count = $house->comments->count();
    $trailingS = $comment_count == 1 ? "" : "s";
    $comments_text = $comment_count. " comment".$trailingS;
    ?>
    <div style="cursor: pointer;" class="house-card a-house-item" data-house="{{$house}}" data-user="{{$house->owner()}}" data-comments="{{$comment_count}}" data-favs="{{$fav_count}}">
        <div class="image" style="background-color: {{$house->placeholder_color}}">
            <img src="{{asset($house_url . $house->image_url)}}" alt="{{$house->title}}">
        </div>
        <div class="content">
            <h3>{{$house->title}}</h3>
            <span class="social-stuff">
            	{{$likes_text}} <span style="display: inline-block; margin-top: -35px;">&nbsp; | &nbsp;</span> {{$comments_text}}
            </span>
        </div>
    </div>
@endforeach