<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Requests\BookmarkRequest;
use App\Models\Coin;
use App\Models\Idea;
use App\Models\Market;
use App\Models\Strategy;
use App\Services\Classes\Bookmark\BookmarkServiceInterface;
use Illuminate\Http\JsonResponse;

class BookmarkController extends Controller
{

    protected BookmarkServiceInterface $service;

    public function __construct(BookmarkServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @throws CustomException
     */
    public function coin(BookmarkRequest $request): JsonResponse
    {
        $this->service->coin($request);
        return jsonResponse();
    }

    /**
     * @param BookmarkRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function market(BookmarkRequest $request): JsonResponse
    {
        $this->service->market($request);
        return jsonResponse();
    }

    /**
     * @param BookmarkRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function strategy(BookmarkRequest $request): JsonResponse
    {
        $this->service->strategy($request);
        return jsonResponse();
    }

    /**
     * @param BookmarkRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function ideaOrNews(BookmarkRequest $request): JsonResponse
    {
        $this->service->ideaOrNews($request);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeCoinBookmark($id): JsonResponse
    {
        $this->service->removeBookmarkByAttributes($id, Coin::class);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeMarketBookmark($id): JsonResponse
    {
        $this->service->removeBookmarkByAttributes($id, Market::class);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeStrategyBookmark($id): JsonResponse
    {
        $this->service->removeBookmarkByAttributes($id, Strategy::class);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function removeIdeaOrNews($id): JsonResponse
    {
        $this->service->removeBookmarkByAttributes($id, Idea::class);
        return jsonResponse();
    }
}
