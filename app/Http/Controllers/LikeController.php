<?php

namespace App\Http\Controllers;


use App\Http\Requests\LikeRequest;
use App\Services\Classes\Like\LikeServiceInterface;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    protected LikeServiceInterface $service;

    public function __construct(LikeServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function likeComment(LikeRequest $request): JsonResponse
    {
        $this->service->likeComment($request);
        return jsonResponse();
    }

    /**
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function likeIdeaOrNews(LikeRequest $request): JsonResponse
    {
        $this->service->likeIdeaOrNews($request);
        return jsonResponse();
    }

    /**
     * @param LikeRequest $request
     * @return JsonResponse
     */
    public function likeMessage(LikeRequest $request): JsonResponse
    {
        $this->service->likeMessage($request);
        return jsonResponse();
    }
}
