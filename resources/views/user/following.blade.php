<div id="userFollowing" class="tab-pane fade in active" style="padding: 0;">    
    @if(is_null($following_count))
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            @if(!$myProfile)
                <span>
                    {{$user->fname}} is not following anyone.
                </span>
            @else
                <span>
                    You are not following anyone.
                </span>
            @endif
        </div>
    @endif

    @foreach($following as $followed)
        <p>$followed->full_name()</p>
    @endforeach
</div>