<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Services\Classes\Announcement\AnnouncementServiceInterface;
use Illuminate\Http\JsonResponse;

class AnnouncementController extends Controller
{
    protected AnnouncementServiceInterface $service;

    public function __construct(AnnouncementServiceInterface $service)
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('only-admin')->except(['index', 'show']);
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return jsonResponse($this->service->index());
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
     * @param AnnouncementRequest $request
     * @return JsonResponse
     */
    public function store(AnnouncementRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param AnnouncementRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AnnouncementRequest $request, $id): JsonResponse
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
