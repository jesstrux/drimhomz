<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\House;

class PostFaved extends Notification
{
    use Queueable;

    private $user;
    private $house;

    public function __construct(User $user, House $house)
    {
        $this->user = $user;
        $this->house = $house;
    }

    public function via($notifiable)
    {
//        return ['database', 'broadcast'];
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $user = $this->user;
        $house = $this->house;

        return [
            'user_id' => $user->id,
            'house_image' => $house->image_url,
            'house_color' => $house->placeholder_color,
            'link' => "/house/".$house->id
        ];
    }
}
