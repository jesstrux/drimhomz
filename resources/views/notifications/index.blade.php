@extends('layouts.app')

@section('content')
    <style>
        body{
            background-color: #fff !important;
        }
    </style>
    <div style="background-color: transparent">
        <ul style="list-style-type: none; width: 100%; max-width: 600px; padding: 8px 0; margin: auto;">
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
                    <li class="{{$unread}}" style="padding: 8px 16px;">
                        @include('notifications.'.snake_case(class_basename($notification->type)))
                    </li>
                @endforeach
            @else
                <li><a style="background: transparent !important; color: #555; margin: 8px 0;">You have no notifications.</a></li>
            @endif
        </ul>
    </div>

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
@endsection