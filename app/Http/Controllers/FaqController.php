<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Services\Classes\FAQ\FaqServiceInterface;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    protected FaqServiceInterface $service;

    public function __construct(FaqServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function showLast(): JsonResponse
    {
        return jsonResponse($this->service->showLast());
    }

    /**
     * @param FaqRequest $request
     * @return JsonResponse
     */
    public function createNew(FaqRequest $request): JsonResponse
    {
        $this->service->createNew($request);
        return jsonResponse();
    }
}
