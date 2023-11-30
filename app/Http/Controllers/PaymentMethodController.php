<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\PaymentMethodRequest;
use App\Services\Classes\PaymentMethod\PaymentMethodServiceInterface;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    protected PaymentMethodServiceInterface $service;

    public function __construct(PaymentMethodServiceInterface $service)
    {
        $this->middleware('auth:sanctum')->except('index');
        $this->middleware('only-admin')->except('index');
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return jsonResponse($this->service->all());
    }

    /**
     * @param PaymentMethodRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(PaymentMethodRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return jsonResponse($this->service->find($id));
    }

    /**
     * @param PaymentMethodRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(PaymentMethodRequest $request, $id): JsonResponse
    {
        $this->service->update($request, $id);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }
}
