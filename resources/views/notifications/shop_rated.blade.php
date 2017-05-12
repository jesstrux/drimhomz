<a class="dh-notif" href="{{url('clearOneNotification/'.$notification->id)}}">
    {{--{{$data['link']}}--}}
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $user_dp}}" alt="{{$user_name}} image" />
        <div class="flex layout wrap vertical">
            <span style="display: block; white-space: normal">
                <strong>{{$user_name}}</strong>
                Rated your shop with: {{$data['rating']}} stars
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
        <div style="background-color: #ddd">
            <img class="dropdown-avatar" src="{{$shop_url . $data['shop_image']}}" alt="shop image" />
        </div>
    </div>
</a>