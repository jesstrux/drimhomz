<?php

namespace App\Notifications;

use App\ExpertRating;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Rating;
use App\User;

class ExpertRated extends Notification
{
    use Queueable;

    private $rating;
    private $user;

    public function __construct(ExpertRating $rating, User $user)
    {
        $this->rating = $rating;
        $this->user = $user;
    }

    public function via($notifiable)
    {
//        return ['database', 'broadcast'];
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $rating = $this->rating;
        $user = $this->user;

        return [
            'user_id' => $user->id,
            'rating' => $rating->rating->rating,
            'link' => "/user/".$rating->expert_id."/reviews#rating".$rating->id
        ];
    }
}
