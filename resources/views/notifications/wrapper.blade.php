<?php
	$notifications = Auth::user()->notifications;
	$unread_count = Auth::user()->unreadNotifications->count();
?>

<li class="dropdown hidden-xs" style="background-color: transparent">
    <a href="javascript:void(0);" class="with-icon" data-toggle="dropdown">
        <i class="fa fa-bell"></i>
        <sup class="badge style-danger">{{$unread_count}}</sup>
    </a>

    <ul class="dropdown-menu" role="menu" style="width: 400px !important; max-height: 300px !important; overflow-y:auto;">
        <li class="dropdown-header layout center">
            Notifications

            @if($unread_count > 0)
                <a style="margin-left: auto; padding: 0; text-decoration: underline; background: transparent !important;"
                   href="javascript:void(0);" onclick="clearNotifications()">
                    Mark all as read
                </a>
            @endif
        </li>

        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
                <?php
                    $data = $notification->data;
                    $unread = $notification->read() ? "" :  "unread";
                ?>
                <li class="{{$unread}}">
                    @include('notifications.'.snake_case(class_basename($notification->type)))
                </li>
            @endforeach
        @else
            <li><a style="background: transparent !important; color: #555; margin: 8px 0;">You have no notifications.</a></li>
        @endif
    </ul>
</li>

<script>
    function clearNotifications(){
        showLoading();

        var token = $(_token).val();
        var formdata = new FormData();
        formdata.append('_token', token);

        $.ajax({
            type:'POST',
            url: "/clearNotifications",
            data: formdata,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false
        })
        .done(function(response){
            console.log("Response!, ", response);
            if(response.success){
                $('.dh-notif').each(function(){
                    $(this).removeClass('unread');
                });
                showToast("success", "Notifications cleared!");
            }else{
                showToast("error", "Couldn't clear notifications!");
            }
        })
        .fail(function(response){
            console.log(response);
            showToast("error", "Couldn't clear notifications");
        })
        .always(function(){
            console.log("Action done");
            hideLoading();
        });
    }
</script>