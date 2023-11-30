<?php

namespace App\Http\Controllers;


use App\Http\Requests\ChangeCommentStatusRequest;
use App\Http\Requests\CommentRequest;
use App\Services\Classes\Comment\CommentServiceInterface;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected CommentServiceInterface $service;

    public function __construct(CommentServiceInterface $service)
    {
        $this->service = $service;
    }


    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function onIdeaOrNews(CommentRequest $request): JsonResponse
    {
        $this->service->onIdeaOrNews($request);
        return jsonResponse();
    }

    /**
     * @param CommentRequest $request
     * @param $commentId
     * @return JsonResponse
     */
    public function reply(CommentRequest $request, $commentId): JsonResponse
    {
        $this->service->reply($request, $commentId);
        return jsonResponse();
    }

    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function update(CommentRequest $request): JsonResponse
    {
        $this->service->update($request);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }

    /**
     * @param ChangeCommentStatusRequest $request
     * @return JsonResponse
     */
    public function updateStatus(ChangeCommentStatusRequest $request): JsonResponse
    {
        $this->service->updateStatus($request);
        return jsonResponse();
    }
}
