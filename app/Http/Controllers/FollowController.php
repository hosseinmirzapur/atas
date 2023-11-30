<?php

namespace App\Http\Controllers;


use App\Http\Requests\FollowRequest;
use App\Services\Classes\Follow\FollowServiceInterface;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    protected FollowServiceInterface $service;

    public function __construct(FollowServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function followings($id): JsonResponse
    {
        return jsonResponse($this->service->followings($id));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function followers($id): JsonResponse
    {
        return jsonResponse($this->service->followers($id));
    }

    /**
     * @param FollowRequest $request
     * @return JsonResponse
     */
    public function follow(FollowRequest $request): JsonResponse
    {
        $this->service->followUser($request);
        return jsonResponse();
    }

    /**
     * @param FollowRequest $request
     * @return JsonResponse
     */
    public function unfollow(FollowRequest $request): JsonResponse
    {
        $this->service->unfollowUser($request);
        return jsonResponse();
    }
}
