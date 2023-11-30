<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Services\Classes\News\NewsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected NewsServiceInterface $service;

    public function __construct(NewsServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(Request $request): JsonResponse
    {
        return jsonResponse($this->service->allForAdmin($request));
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
     * @param IdeaRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(IdeaRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param UpdateNewsRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(UpdateNewsRequest $request, $id): JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function forUsers(Request $request): JsonResponse
    {
        return jsonResponse($this->service->forUsers($request));
    }
}
