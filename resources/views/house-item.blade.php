<li style="cursor: pointer;" id="house{{$house->id}}"
	class="dh-card grid-item a-house a-new-house a-house-item"
	data-postid="{{$house->id}}"
	data-house="{{$house}}" data-user="{{$owner}}" data-comments="{{$comment_count}}" data-favs="{{$fav_count}}">
	@if(Auth::user())
		<div class="post-actions">
			<button class="btn drim-btn"><img class="drimmer" src="{{asset('images/drim.png')}}" height="20px"/></button>
			<form action="" id="followHouse{{$house->id}}" method="POST">
				{{csrf_field()}}
				<button class="btn follow-house-btn {{$followed_class}}" type="button" onclick="followHouse({{$house->id}})">{{$followed_str}}</button>
			</form>
		</div>
	@endif
	<div class="image" style="background-color: {{$house->placeholder_color}};">
		<img style="background-color: transparent;" src="{{$house_url . 'thumbs/' . $house->image_url}}" alt="{{$house->title}}">
    </div>
	<div class="content">
		<h3>{{$house->title}}</h3>
		<a class="user-link hidden-xs hidden-sm" href="{{url('/user/' . $owner->id)}}" data-user-id="{{$owner->id}}">
            {{$owner->fname . ' ' . $owner->lname}}
        </a>
		<a class="hidden visible-xs visible-sm" href="{{url('/user/' . $owner->id)}}" onclick="showUserBottomSheet({{$owner->id}})">
            {{$owner->fname . ' ' . $owner->lname}}
        </a>
		<span class="social-stuff">{{$likes_text}}&nbsp;|&nbsp;{{$comments_text}}</span>
    </div>
</li>