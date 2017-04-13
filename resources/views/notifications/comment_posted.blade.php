<a class="dh-notif" href="{{$data['link']}}">
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $data['user_dp']}}" alt="{{$data['user_name']}} image" />
        <div class="flex layout wrap vertical">
            <span style="display: block; white-space: normal">
                <strong>{{$data['user_name']}}</strong>
                Commented on your post: "{{str_limit($data['comment'], 25)}}"
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
        <div style="background-color: {{$data['house_color']}}">
            <img class="dropdown-avatar" src="{{$house_url . $data['house_image']}}" alt="house image" />
        </div>
    </div>
</a>