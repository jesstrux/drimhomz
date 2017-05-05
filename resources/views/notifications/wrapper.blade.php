<?php
	$notifications = Auth::user()->notifications;
	$unread_count = Auth::user()->unreadNotifications->count();
?>

<li class="dropdown hidden-xs" style="background-color: transparent">
    <a href="javascript:void(0);" class="with-icon" data-toggle="dropdown">
        <i class="fa fa-bell"></i>
        <sup class="badge style-danger">@if($unread_count>0){{$unread_count}}@endif</sup>
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
				    $user_dp =  "def.png";
				    $user_name = "Unknown user";

				    if($data['user_id'] && $data['user_id'] != null){
					    $user = App\User::find($data['user_id']);
					    $user_dp =  $user->dp;
					    $user_name = $user->fname . " " . $user->lname;
				    }
                ?>
                <li class="{{$unread}}">
                    @include('notifications.'.snake_case(class_basename($notification->type)))
                </li>
            @endforeach
        @else
            <li>
	            <div class="dh-notif" style="padding: 2px 16px;">
		            <div class="layout">
			            <span class="img-circle dropdown-avatar self-center layout center-center" style="margin-top: -5px; padding: 5px; background-color: #e0e0e0 !important">
				            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"/></svg>
			            </span>
			            <div class="flex layout wrap vertical">
				            <span style="display: block; white-space: normal">
				                <strong>Nothing here</strong><br>
				                You have no notifications yet.
				            </span>
			            </div>
		            </div>
	            </div>
            </li>
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
	            //                    $('.unread').each(function(){
//                        $(this).removeClass('unread');
//                    });
	            $(".unread").removeClass('unread');
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