<a class="dh-notif" href="{{url('clearOneNotification/'.$notification->id)}}">
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $user_dp}}" alt="{{$user_name}} image" />
        <div class="flex layout wrap vertical">
            <span style="display: block; white-space: normal">
                <strong>{{$user_name}}</strong>
                Commented on your article: "{{str_limit($data['comment'], 25)}}"
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
    </div>
</a>