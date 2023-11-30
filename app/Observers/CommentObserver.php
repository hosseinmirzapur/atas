<?php

namespace App\Observers;

use App\Classes\Services\Email\EmailCodeService;
use App\Classes\Services\SMS\SmsCodeService;
use App\Exceptions\CustomException;
use App\Models\Comment;
use App\Models\Idea;

class CommentObserver
{
    /**
     * @throws CustomException
     */
    public function created(Comment $comment)
    {
        $user = $comment->user;
        if ($comment->commentable_type == Idea::class) {
            $this->handleCommentEvents($user);
        }
        if ($comment->related_comment_id != null) {
            $this->handleReplyEvents($user);
        }
    }

    /**
     * @throws CustomException
     */
    protected function handleCommentEvents($user)
    {
        if ($user->sms_when_commented) {
            $sms = new SmsCodeService();
            if (exists($user->profile)) {
                $sms->send($user->profile->phone_number, 'COMMENT');
            }
        }
        if ($user->email_when_commented) {
            $email = new EmailCodeService();
            $email->send($user->email, 'COMMENT');
        }
    }

    /**
     * @param $user
     * @throws CustomException
     */
    protected function handleReplyEvents($user)
    {
        if ($user->sms_when_replied) {
            $sms = new SmsCodeService();
            if (exists($user->profile)) {
                $sms->send($user->profile->phone_number, 'REPLY');
            }
        }
        if ($user->email_when_replied) {
            $email = new EmailCodeService();
            $email->send($user->email, 'REPLY');
        }
    }
}
