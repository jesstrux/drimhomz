<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Rating;
use App\User;

class ShopRated extends Notification
{
    use Queueable;

    private $rating;
    private $user;

    public function __construct(Rating $rating, User $user)
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
            'user_name' => $user->fname ." ". $user->lname,
            'user_dp' => $user->dp,
            'rating' => $rating->rating,
            'shop_image' => $rating->ratable->image_url,
            'link' => "/shop/".$rating->ratable_id."/reviews#rating".$rating->id
        ];
    }
}
