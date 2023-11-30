<?php

namespace App\Services\Classes\Follow;

use App\Http\Requests\FollowRequest;

interface FollowServiceInterface
{
    /**
     * @param FollowRequest $request
     */
    public function followUser(FollowRequest $request);

    /**
     * @param FollowRequest $request
     */
    public function unfollowUser(FollowRequest $request);

    /**
     * @param $user_id
     * @return array
     */
    public function followers($user_id): array;

    /**
     * @param $user_id
     * @return array
     */
    public function followings($user_id): array;
}
