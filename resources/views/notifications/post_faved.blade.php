<a class="dh-notif" href="{{$data['link']}}">
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $data['user_dp']}}" alt="{{$data['user_name']}} image" />
        <div class="flex layout vertical">
            <span>
                <strong>{{$data['user_name']}}</strong>
                Liked your post
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
        <div style="background-color: {{$data['house_image']}}">
            <img class="dropdown-avatar" src="{{$house_url . $data['house_image']}}" alt="house image" />
        </div>
    </div>
</a>