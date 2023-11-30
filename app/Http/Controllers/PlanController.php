<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Requests\GrantOptionsToPlanRequest;
use App\Http\Requests\PlanRequest;
use App\Services\Classes\Plan\PlanServiceInterface;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    protected PlanServiceInterface $service;

    public function __construct(PlanServiceInterface $service)
    {
        $this->service = $service;
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('only-admin')->except(['index', 'show']);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return jsonResponse($this->service->all());
    }

    /**
     * @param PlanRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(PlanRequest $request): JsonResponse
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
        return jsonResponse($this->service->show($id));
    }

    /**
     * @param PlanRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PlanRequest $request, $id): JsonResponse
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

    /**
     * @param GrantOptionsToPlanRequest $request
     * @return JsonResponse
     */
    public function grantOptionsToPlan(GrantOptionsToPlanRequest $request): JsonResponse
    {
        $this->service->grantOptionsToPlan($request);
        return jsonResponse();
    }
}
