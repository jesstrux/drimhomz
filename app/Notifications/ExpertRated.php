<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ExpertRating;
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
            'user_name' => $user->fname ." ". $user->lname,
            'user_dp' => $user->dp,
            'rating' => $rating->rating,
            'comment' => $rating->comment,
            'link' => "office/".$user->office->id."/ratings/#rating".$rating->id
        ];
    }
}
