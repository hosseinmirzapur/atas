<?php


namespace App\Services\Procedures;


use App\Exceptions\CustomException;
use App\Repository\Structure\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginProcedure
{
    protected UserRepository $repo;

    public function __construct(UserRepository $repository)
    {
        $this->repo = $repository;
    }

    /**
     * @param $email
     * @param $password
     * @return array
     * @throws CustomException
     */
    public function generateToken($email, $password): array
    {
        $user = $this->repo->findOneByAttr('email', $email);
        if (!Hash::check($password, $user->password)) {
            throw new CustomException(trans('messages.WRONG_CREDENTIALS'));
        }
        $token = $user->createToken('userToken')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
