<?php

namespace App\Notifications;

use App\ArticleComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Answer;
use App\User;

class ArticleCommentReceived extends Notification
{
    use Queueable;

    private $comment;
    private $user;

    public function __construct(ArticleComment $comment, User $user)
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
            'article_id' => $comment->article->id,
            'comment_id' => $comment->id,
            'comment' => $comment->content,
            'link' => "article/".$comment->article->id."/#comment".$comment->id
        ];
    }
}
