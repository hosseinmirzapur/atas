<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\MessageForwardRequest;
use App\Http\Requests\MessageReplyRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;
use App\Services\Classes\Message\MessageServiceInterface;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    protected MessageServiceInterface $service;

    public function __construct(MessageServiceInterface $service)
    {
        $this->service = $service;
        $this->middleware('authorized')->except(['forward', 'chatMessages']);
    }

    /**
     * @param MessageRequest $request
     * @return JsonResponse
     */
    public function store(MessageRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param MessageRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(MessageRequest $request, $id): JsonResponse
    {
        $this->service->update($request, $id);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }

    /**
     * @param MessageReplyRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function reply(MessageReplyRequest $request): JsonResponse
    {
        $this->service->reply($request);
        return jsonResponse();
    }

    /**
     * @param MessageForwardRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function forward(MessageForwardRequest $request): JsonResponse
    {
        $this->service->forward($request);
        return jsonResponse();
    }

    /**
     * @param Chat $chat
     * @return JsonResponse
     * @throws CustomException
     */
    public function chatMessages(Chat $chat): JsonResponse
    {
        $data = $this->service->chatMessages($chat);
        return jsonResponse($data);
    }
}
