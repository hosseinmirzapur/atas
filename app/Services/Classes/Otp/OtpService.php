<?php


namespace App\Services\Classes\Otp;


use App\Exceptions\CustomException;
use App\Http\Requests\ChangePassFromForgetPassRequest;
use App\Http\Requests\ForgetPasswordOtpConfirmRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpCheckRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repository\Structure\ReferralRepository;
use App\Repository\Structure\UserRepository;
use App\Services\Procedures\ForgetPasswordProcedure;
use App\Services\Procedures\LoginProcedure;
use App\Services\Procedures\RegisterProcedure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class OtpService implements OtpServiceInterface
{
    protected UserRepository $userRepository;
    protected RegisterProcedure $registerProcedure;
    protected ReferralRepository $referralRepository;
    protected LoginProcedure $loginProcedure;
    protected ForgetPasswordProcedure $forgetPasswordProcedure;

    public function __construct(
        UserRepository $userRepository,
        RegisterProcedure $registerProcedure,
        LoginProcedure $loginProcedure,
        ForgetPasswordProcedure $forgetPasswordProcedure,
        ReferralRepository $referralRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->registerProcedure = $registerProcedure;
        $this->loginProcedure = $loginProcedure;
        $this->forgetPasswordProcedure = $forgetPasswordProcedure;
        $this->referralRepository = $referralRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['code' => "int|string"])] public function register(RegisterRequest $request): array
    {
        $email = $request->email;
        $password = $request->password;
        $invitation_code = $request->invitation_code;
        $user = User::query()->updateOrCreate(['email' => $email], [
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        if (!is_null($invitation_code) && $invitation_code != '' && ($user instanceof User)) {
            $this->handleReferral($invitation_code, $user);
        }
        $code = $this->registerProcedure->otp($email);
        return [
            'code' => $code
        ];
    }


    /**
     * @param string $code
     * @param User $user
     * @throws CustomException
     */
    protected function handleReferral(string $code, User $user)
    {
        if (!$this->codeExists($code)) {
            $this->userRepository->forceDeleteById($user->id);
            throw new CustomException(trans('messages.WRONG_REFERRAL'));
        } else {
            $this->referralRepository->createOne([
                'referral_code' => $code,
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * @param string $code
     * @return bool
     */
    protected function codeExists(string $code): bool
    {
        return !is_null($this->referralRepository->findOneByAttr('referral_code', $code, [], false));
    }

    /**
     * @param OtpCheckRequest $request
     * @throws CustomException
     */
    public function confirmOtp(OtpCheckRequest $request): void
    {
        $email = $request->email;
        $code = $request->code;
        $this->registerProcedure->verify($email, $code);
        $user = $this->userRepository->findOneByAttr('email', $email);
        $user->update([
            'status' => 'OTP_DONE'
        ]);
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['code' => "mixed", 'token' => "\Ramsey\Uuid\UuidInterface"])] public function forgetPass(ForgetPasswordRequest $request): array
    {
        $email = $request->email;
        $this->userRepository->findOneByAttr('email', $email);
        $token = $this->forgetPasswordProcedure->otp($email);
        $code = Cache::get($email);
        return [
            'code' => $code,
            'token' => $token
        ];
    }

    /**
     * @param ForgetPasswordOtpConfirmRequest $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['token' => "mixed"])] public function confirmForgetPasswordCode(ForgetPasswordOtpConfirmRequest $request): array
    {
        $token = $request->token;
        $email = $request->email;
        $code = $request->code;

        $this->forgetPasswordProcedure->verify($token, $email, $code);
        return [
            'token' => Cache::get($email)
        ];
    }

    /**
     * @param ChangePassFromForgetPassRequest $request
     * @throws CustomException
     */
    public function changePassFromForgetPass(ChangePassFromForgetPassRequest $request)
    {
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;
        $email = $request->email;
        if ($new_password != $confirm_password) {
            throw new CustomException(trans('messages.PASSWORDS_NOT_MATCH'));
        }
        $sent_token = Cache::get($email);
        $token = $request->token;
        if ($sent_token != $token) {
            throw new CustomException(trans('messages.NOT_AUTHORIZED'));
        }
        $this->userRepository->findOneByAttr('email', $email)->update([
            'password' => Hash::make($new_password)
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return array
     * @throws CustomException
     */
    #[ArrayShape(['token' => "mixed", 'profile' => "mixed"])] public function login(LoginRequest $request): array
    {
        $email = $request->email;
        $password = $request->password;
        $data = $this->loginProcedure->generateToken($email, $password);
        $user = $data['user'];
        $token = $data['token'];
        return [
            'token' => $token,
            'profile' => $user->profile ?? $user->only(['email'])
        ];
    }

    public function logout()
    {
        currentUser()->tokens()->delete();
    }
}
