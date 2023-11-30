<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeBillingStatusRequest;
use App\Http\Requests\PayRequest;
use App\Services\Classes\Billing\BillingServiceInterface;
use Illuminate\Http\JsonResponse;

class BillingController extends Controller
{
    protected BillingServiceInterface $service;

    public function __construct(BillingServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return jsonResponse($this->service->all());
    }

    /**
     * @param PayRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function pay(PayRequest $request): JsonResponse
    {
        $this->service->pay($request);
        return jsonResponse();
    }

    /**
     * @param ChangeBillingStatusRequest $request
     * @return JsonResponse
     */
    public function changeBillingStatus(ChangeBillingStatusRequest $request): JsonResponse
    {
        $this->service->changeBillingStatus($request);
        return jsonResponse();
    }
}
