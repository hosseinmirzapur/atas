<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Requests\OptionRequest;
use App\Services\Classes\Option\OptionServiceInterface;
use Illuminate\Http\JsonResponse;

class OptionController extends Controller
{
    protected OptionServiceInterface $service;

    public function __construct(OptionServiceInterface $service)
    {
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
     * @param OptionRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(OptionRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param OptionRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(OptionRequest $request, $id): JsonResponse
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
