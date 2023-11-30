<?php

namespace App\Observers;

use App\Classes\Services\Email\EmailCodeService;
use App\Classes\Services\SMS\SmsCodeService;
use App\Exceptions\CustomException;
use App\Models\Follow;
use App\Models\User;

class FollowObserver
{
    /**
     * @param Follow $follow
     * @throws CustomException
     */
    public function created(Follow $follow)
    {
        $user = User::query()->find($follow->following_user_id);
        $this->handleEvents($user);

    }
    /**
     * @throws CustomException
     */
    protected function handleEvents($user) {
        if ($user->sms_when_followed) {
            $sms = new SmsCodeService();
            if (exists($user->profile)) {
                $sms->send($user->profile->phone_number, 'FOLLOW');
            }
        }
        if ($user->email_when_followed) {
            $email = new EmailCodeService();
            $email->send($user->email, 'FOLLOW');
        }
    }
}
