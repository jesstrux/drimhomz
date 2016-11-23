<section id="pictures" class="short hidden">
    <div class="container">
        <div class="section-header text-center">
            <h3>Featured houses</h3>
            <p>
                Here's today's collection, hope you find some that you like, if you do don't forget to rate them so others can find them too. <br>
                <button class="round-btn" style="padding: 5px 20px; min-width: 0">Suggest a house</button>
            </p>
        </div>
    </div>
</section>

<div class="image-grid">
    <?php
        $notnull = count($randomHouses) > 0;
    ?>
    @if($notnull)
        <style>
                    body{
                        background-color: #eee;
                    }
                    #container{
                        list-style: none;
                        display: block;
                        position: relative;
                        padding: 0;
                        margin: 0;
                    }
                    .grid-sizer, .dh-card{
                        width: calc(20% - 10px);
                        /*background-color: red;*/
                        /*display: block;*/
                    }
                    .dh-card{
                        display: inline-block;
                        margin: 0 5px; margin-bottom: 15px; border-radius: 10px;
                        margin: 0;
                    }

                    .dh-card .image{
                        border-radius: 10px 10px 0 0;
                    }

                    @media all and (max-width: 900px) {
                        .grid-sizer, .dh-card{
                            width: calc(33.333% - 10px);
                        }
                    }

                    @media all and (max-width: 768px) {
                        .grid-sizer, .dh-card{
                            width: calc(50% - 10px);
                        }
                    }

                    @media all and (max-width: 406px) {
                        .grid-sizer, .dh-card{
                            width: calc(100% - 10px);
                        }
                    }

                    .dh-card p{
                        margin: 0;
                        white-space: nowrap;
                        overflow: hidden;
                        -ms-text-overflow: ellipsis;
                        text-overflow: ellipsis;
                    }
                </style>

        <ul id="container">
            @foreach($randomHouses as $house)
                <?php
                    $trailingS = $house->fav_count == 1 ? "" : "s";
                    $likes_text = $house->fav_count. " like".$trailingS;

                    $trailingS = $house->comment_count == 1 ? "" : "s";
                    $comments_text = $house->comment_count. " comment".$trailingS;
                ?>
                <!-- <div class="grid-sizer"></div> -->
                <li class="dh-card grid-item">
                    <div class="image">
                        <img src="{{asset($house->image_url)}}" alt="modern bath">
                    </div>
                    <div class="content">
                        <h3>{{$house->title}}</h3>
                        <p>{{str_limit($house->description, $limit = 50, $end = '...')}}</p>
                        <span class="social-stuff">{{$likes_text}} | {{$comments_text}}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="empty-message">There are no featured houses.</div>
    @endif
</div>