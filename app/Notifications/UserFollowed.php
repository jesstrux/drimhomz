<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class UserFollowed extends Notification
{
    use Queueable;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
//        return ['database', 'broadcast'];
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $user = $this->user;

        return [
            'user_id' => $user->id,
            'user_dp' => $user->dp,
            'user_name' => $user->fname ." ". $user->lname,
            'link' => '/user/'.$user->id
        ];
    }
}
