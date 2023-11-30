<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Services\Classes\Profile\ProfileServiceInterface;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    protected ProfileServiceInterface $service;

    public function __construct(ProfileServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param ProfileRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        $this->service->updateOrCreate($request);
        return jsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = $this->service->read();
        return jsonResponse($data);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->service->changePassword($request);
        return jsonResponse();
    }
}
