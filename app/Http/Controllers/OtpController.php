<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangePassFromForgetPassRequest;
use App\Http\Requests\ForgetPasswordOtpConfirmRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpCheckRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Classes\Otp\OtpServiceInterface;
use Illuminate\Http\JsonResponse;

class OtpController extends Controller
{
    protected OtpServiceInterface $service;

    public function __construct(OtpServiceInterface $service)
    {
        $this->service = $service;

    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->service->login($request);
        return jsonResponse($data);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->service->register($request);
        return jsonResponse($data);
    }

    /**
     * @param OtpCheckRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function confirmOtp(OtpCheckRequest $request): JsonResponse
    {
        $this->service->confirmOtp($request);
        return jsonResponse([
            'message' => trans('messages.SUCCESS')
        ]);
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function forgetPass(ForgetPasswordRequest $request): JsonResponse
    {
        $data = $this->service->forgetPass($request);
        return jsonResponse($data);
    }

    /**
     * @param ForgetPasswordOtpConfirmRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function confirmForgetPasswordCode(ForgetPasswordOtpConfirmRequest $request): JsonResponse
    {
        $data = $this->service->confirmForgetPasswordCode($request);
        return jsonResponse($data);
    }

    /**
     * @param ChangePassFromForgetPassRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function changePassFromForgetPass(ChangePassFromForgetPassRequest $request): JsonResponse
    {
        $this->service->changePassFromForgetPass($request);
        return jsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->service->logout();
        return jsonResponse(trans('messages.SUCCESSFUL_LOGOUT'));
    }
}
