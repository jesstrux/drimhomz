@if($myProfile)
    <a id="createShopBtn" href="javascript:void(0);" class="new-button" onclick="openNewShop()">
        <div id="createHouse" class="image layout center-center" style="background: #eee; height: 200px">
            <svg fill="#777" height="120" viewBox="0 0 24 24" width="120" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
            </svg>
        </div>
        <div style="margin-to: 5px;">
            <h3 style="font-size: 1.3em; margin: 0; padding: 12px 0;text-align: center;height: 40px; line-height: 30px">New Shop</h3>
        </div>
    </a>
@else
    @if(is_null($shops))
        @if(!$myProfile)
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                {{$user->fname}} has no shops yet.
            </div>
        @else
            <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
                You have no shops.
            </div>
        @endif
    @endif
@endif


<div id="usersSubsList" class="layout wrap" style="margin-bottom: 10px;">
    @include('user.shops-list')
</div>

@if($following_count > $per_page)
    <button id="userMoreBtn" class="btn btn-default btn-block" style="padding: 10px 0;" onclick="getMore()">LOAD MORE</button>
@endif