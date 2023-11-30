<?php


namespace App\Services\Procedures;


use App\Exceptions\CustomException;
use App\Jobs\SendCodeToEmail;
use App\Repository\Structure\UserRepository;
use App\Services\Codes\EmailCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class ForgetPasswordProcedure
{
    protected UserRepository $repo;

    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * @param $email
     * @return UuidInterface
     * @throws CustomException
     */
    public function otp($email): UuidInterface
    {
        $code = EmailCode::generateCode();
        Cache::put($email, $code, 120);
//        dispatch(new SendCodeToEmail($email, $code));
        $token = Str::uuid();
        Cache::put($email . '|' . $code, $token, 120);
        return $token;
    }

    /**
     * @param $token
     * @param $email
     * @param $code
     * @return bool
     * @throws CustomException
     */
    public function verify($token, $email, $code): bool
    {
        $sentCode = Cache::get($email);
        if ($code != $sentCode) {
            throw new CustomException(trans('messages.WRONG_CODE'));
        }
        $previousToken = Cache::get($email . '|' . $sentCode);
        if ($token != $previousToken) {
            throw new CustomException(trans('messages.NOT_AUTHORIZED'));
        }

        Cache::put($email, Str::uuid(), 120);

        return true;
    }
}
