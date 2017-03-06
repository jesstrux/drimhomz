<section class="short">
    <div class="section-header text-center">
        <h3>Featured Houses ({{$today}})</h3>
        <p>
            To add a new house to the featured list, click the button below.<br>
            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Add house</button>
        </p>
    </div>
</section>

<section>
    <?php
        $notnull = count($randomHouses) > 0;
    ?>
    @if($notnull)
        <div style="padding: 0 30px; max-width: calc(100% - 60px); position: relative;" class="layout wrap">
            @foreach($randomHouses as $house)
                <?php
                    $trailingS = $house->fav_count == 1 ? "" : "s";
                    $likes_text = $house->fav_count. " like".$trailingS;

                    $trailingS = $house->comment_count == 1 ? "" : "s";
                    $comments_text = $house->comment_count. " comment".$trailingS;
                ?>
                <div class="dh-card" style="width: calc(33.333% - 20px); margin: 10px">
                    <div class="image">
                        <img src="{{asset($house->image_url)}}" alt="modern bath">
                    </div>
                    <div class="content">
                        <h3>{{$house->title}}</h3>
                        {{str_limit($house->description, $limit = 50, $end = '...')}}
                        <span class="social-stuff">{{$likes_text}} | {{$comments_text}}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-message">There are no featured houses.</div>
    @endif
</section>