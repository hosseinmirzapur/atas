<?php


namespace App\Services\Classes\Message;


use App\Exceptions\CustomException;
use App\Http\Requests\MessageForwardRequest;
use App\Http\Requests\MessageReplyRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Chat;

interface MessageServiceInterface
{
    /**
     * @param MessageRequest $request
     */
    public function create(MessageRequest $request);

    /**
     * @param MessageRequest $request
     * @param $id
     */
    public function update(MessageRequest $request, $id);

    /**
     * @param $id
     * @throws CustomException
     */
    public function delete($id);

    /**
     * @param MessageReplyRequest $request
     * @throws CustomException
     */
    public function reply(MessageReplyRequest $request);

    /**
     * @param MessageForwardRequest $request
     * @throws CustomException
     */
    public function forward(MessageForwardRequest $request);

    /**
     * @param Chat $chat
     * @throws CustomException
     * @return array
     */
    public function chatMessages(Chat $chat): array;
}
