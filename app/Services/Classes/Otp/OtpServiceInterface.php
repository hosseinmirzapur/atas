<?php

namespace App\Services\Classes\Otp;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangePassFromForgetPassRequest;
use App\Http\Requests\ForgetPasswordOtpConfirmRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpCheckRequest;
use App\Http\Requests\RegisterRequest;

interface OtpServiceInterface
{
    /**
     * @param RegisterRequest $request
     * @return array
     * @throws CustomException
     */
    public function register(RegisterRequest $request): array;

    /**
     * @param OtpCheckRequest $request
     * @throws CustomException
     */
    public function confirmOtp(OtpCheckRequest $request): void;

    /**
     * @param ForgetPasswordRequest $request
     * @return array
     * @throws CustomException
     */
    public function forgetPass(ForgetPasswordRequest $request): array;

    /**
     * @param ForgetPasswordOtpConfirmRequest $request
     * @return array
     * @throws CustomException
     */
    public function confirmForgetPasswordCode(ForgetPasswordOtpConfirmRequest $request): array;

    /**
     * @param LoginRequest $request
     * @return array
     * @throws CustomException
     */
    public function login(LoginRequest $request): array;

    /**
     * @param ChangePassFromForgetPassRequest $request
     * @throws CustomException
     */
    public function changePassFromForgetPass(ChangePassFromForgetPassRequest $request);

    public function logout();
}
