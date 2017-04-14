<a class="dh-notif" href="{{$data['link']}}">
    <div class="layout">
        <img class="img-circle dropdown-avatar" src="{{$user_url . $data['user_dp']}}" alt="{{$data['user_name']}} image" />
        <div class="flex layout wrap vertical">
            <span style="display: block; white-space: normal">
                <strong>{{$data['user_name']}}</strong>
                Rated you with: {{$data['rating']}} stars
            </span>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
    </div>
</a>