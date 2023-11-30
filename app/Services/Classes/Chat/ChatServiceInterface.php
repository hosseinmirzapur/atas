<?php

namespace App\Services\Classes\Chat;

use App\Exceptions\CustomException;
use App\Http\Requests\StartChatRequest;

interface ChatServiceInterface
{
    /**
     * @param StartChatRequest $request
     */
    public function create(StartChatRequest $request);

    /**
     * @return array
     */
    public function userChats(): array;

    /**
     * @param $chatId
     * @throws CustomException
     */
    public function delete($chatId);
}
