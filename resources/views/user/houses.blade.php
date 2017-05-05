@if($myProfile)
    <a href="javascript:void(0);" class="new-button" onclick="openNewHouse()">
        <div class="image layout center-center" style="background: #eee;">
            <svg fill="#555" height="100" viewBox="0 0 24 24" width="100" xmlns="http://www.w3.org/2000/svg">
			    <path d="M0 0h24v24H0z" fill="none"/>
			    <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
			</svg>
        </div>
        <div style="height: 50px;">
        	<h3 style="font-size: 1.5em; margin: 0; text-align: center;line-height: 70px">New Dream</h3>
        </div>
    </a>
@elseif(is_null($house_count))
    @if(!$myProfile)
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            {{$user->fname}} has no houses yet.
        </div>
    @else
        <div style="padding: 20px; background-color: #f0f0f0; text-align: center; margin: 10px auto;">
            You have no houses.
        </div>
    @endif
@endif


<div id="usersSubsList" class="layout wrap" style="margin-bottom: 10px;">
    @include('user.houses-list')
</div>

@if($house_count > $per_page)
    <button id="userMoreBtn" class="btn btn-default btn-block" style="padding: 10px 0;" onclick="getMore()">LOAD MORE</button>
@endif

@include('houses.new-house')