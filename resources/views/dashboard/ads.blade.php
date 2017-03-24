<section class="short">
    <div class="section-header text-center">
        <h3>Featured Ads ({{$today}})</h3>
        <p>
            To add a new advertisement to the featured list, click the button below.<br>
            <button class="round-btn" style="padding: 5px 20px; min-width: 0">Add Advertisement</button>
        </p>
    </div>
</section>

<section>
    <?php
        $notnull = count($randomAds) > 0;
    ?>
    @if($notnull)
        <div style="padding: 0 30px; max-width: calc(100% - 60px); position: relative;" class="layout wrap">
            @foreach($randomAds as $ad)
                <a href="{{$ad->link}}">
                    {{$ad->image_url}}
                    <p>{{$ad->title}}</p>
                </a>
                <a href="{{$ad->link}}" class="house-card">
                    <div class="image" style="pointer-events: auto;">

                        <img src="/images/categories/uploads/banners/{!! $ad->image_url !!}">
                    </div>
                    <div class="content">
                        <h3 style="line-height: 30px;margin: 0; margin-top: 4px;">{{$ad->title}}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-message">There are no featured ads.</div>
    @endif
</section>
