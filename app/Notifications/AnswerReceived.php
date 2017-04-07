<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Answer;
use App\User;

class AnswerReceived extends Notification
{
    use Queueable;

    private $answer;
    private $user;

    public function __construct(Answer $answer, User $user)
    {
        $this->answer = $answer;
        $this->user = $user;
    }

    public function via($notifiable)
    {
//        return ['database', 'broadcast'];
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $answer = $this->answer;
        $user = $this->user;

        return [
            'user_id' => $user->id,
            'user_name' => $user->fname ." ". $user->lname,
            'user_dp' => $user->dp,
            'question_id' => $answer->question->id,
            'answer_id' => $answer->id,
            'answer' => $answer->content,
            'link' => "question/".$answer->question->id."/#answer".$answer->id
        ];
    }
}
