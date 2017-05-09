<div id="usersSubsList" class="layout wrap" style="margin-bottom: 10px;">
    @if(is_null($articles_count))
        @if(!$myProfile)
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                {{$user->fname}} has not written any articles yet.
            </div>
        @else
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                You have no articles.
            </div>
        @endif
    @endif

    @include('user.articles-list')
</div>

@if($following_count > $per_page)
    <button id="userMoreBtn" class="btn btn-default btn-block" style="padding: 10px 0;" onclick="getMore()">LOAD MORE</button>
@endif