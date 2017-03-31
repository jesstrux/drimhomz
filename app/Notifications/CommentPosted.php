<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Comment;
use App\User;

class CommentPosted extends Notification
{
    use Queueable;

    private $comment;
    private $user;

    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    public function via($notifiable)
    {
//        return ['database', 'broadcast'];
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $comment = $this->comment;
        $user = $this->user;

        return [
            'user_id' => $user->id,
            'user_name' => $user->fname ." ". $user->lname,
            'user_dp' => $user->dp,
            'house_id' => $comment->house->id,
            'house_image' => $comment->house->image_url,
            'house_color' => $comment->house->placeholder_color,
            'comment_id' => $comment->id,
            'comment' => $comment->content,
            'link' => "house/".$comment->house->id."/#comment".$comment->id
        ];
    }
}
