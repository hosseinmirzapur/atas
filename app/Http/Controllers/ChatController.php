<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Requests\StartChatRequest;
use App\Services\Classes\Chat\ChatServiceInterface;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    protected ChatServiceInterface $service;

    public function __construct(ChatServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param StartChatRequest $request
     * @return JsonResponse
     */
    public function create(StartChatRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return jsonResponse($this->service->userChats());
    }

    /**
     * @param $chatId
     * @return JsonResponse
     * @throws CustomException
     */
    public function delete($chatId): JsonResponse
    {
        $this->service->delete($chatId);
        return jsonResponse();
    }
}
