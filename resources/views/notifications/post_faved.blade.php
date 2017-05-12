<a class="dh-notif" href="{{url('clearOneNotification/'.$notification->id)}}">
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $user_dp}}" alt="{{$user_name}} image" />
        <div class="flex layout vertical">
            <span>
                <strong>{{$user_name}}</strong>
                Liked your post
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
        <div style="background-color: {{$data['house_color']}}">
            <img class="dropdown-avatar" src="{{$house_url . $data['house_image']}}" alt="house image" />
        </div>
    </div>
</a>