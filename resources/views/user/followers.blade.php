<div id="userFollowers" class="tab-pane fade" style="padding: 0;">
    @if(is_null($followers_count))
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            @if(!$myProfile)
                <span>
                    {{$user->fname}} has no followers yet.
                </span>
            @else
                <span>
                    You have no followers yet.
                </span>
            @endif
        </div>
    @endif

    @foreach($followers as $follower)
        <p>$follower->full_name()</p>
    @endforeach
</div>