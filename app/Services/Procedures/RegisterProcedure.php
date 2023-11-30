<?php


namespace App\Services\Procedures;


use App\Exceptions\CustomException;
use App\Jobs\SendCodeToEmail;
use App\Repository\Structure\UserRepository;
use App\Services\Codes\EmailCode;
use Illuminate\Support\Facades\Cache;

class RegisterProcedure
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @return int|string
     * @throws CustomException
     */
    public function otp(string $email): int|string
    {
        $code = EmailCode::generateCode();
//        dispatch(new SendCodeToEmail($email, $code));
        Cache::put($email, $code, 120);

        // Todo: Remove this after main server
        return $code;
    }

    /**
     * @param $email
     * @param $code
     * @return bool
     * @throws CustomException
     */
    public function verify($email, $code): bool
    {
        $sentCode = Cache::get($email);
        if ($sentCode != $code) {
            throw new CustomException(trans('messages.OTP_WRONG'), 400);
        }
        return true;
    }
}
