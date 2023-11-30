<?php

namespace App\Services\Classes\Like;

use App\Http\Requests\LikeRequest;

interface LikeServiceInterface
{
    /**
     * @param LikeRequest $request
     */
    public function likeComment(LikeRequest $request);

    /**
     * @param LikeRequest $request
     */
    public function likeIdeaOrNews(LikeRequest $request);

    /**
     * @param LikeRequest $request
     */
    public function likeMessage(LikeRequest $request);
}
