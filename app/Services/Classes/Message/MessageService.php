<?php


namespace App\Services\Classes\Message;


use App\Events\MessageEvent;
use App\Exceptions\CustomException;
use App\Http\Requests\MessageForwardRequest;
use App\Http\Requests\MessageReplyRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Repository\Structure\MessageRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class MessageService implements MessageServiceInterface
{
    protected MessageRepository $messageRepository;

    public function __construct(MessageRepository $repository)
    {
        $this->messageRepository = $repository;
    }

    /**
     * @param MessageRequest $request
     * @throws CustomException
     */
    public function create(MessageRequest $request)
    {
        $data = filterRequest($request->validated());
        $this->checkRequestValidity($data);
        $this->handleRequestFile($data);
        $data['user_id'] = currentUser()->getAttribute('id');

        // check if users already have an existing chat
        $chat1 = $this->messageChat($data['user_id'], $data['other_user_id']);
        $chat2 = $this->messageChat($data['other_user_id'], $data['user_id']);
        if (exists($chat1)) {
            $mainChat = $chat1;
        } elseif (exists($chat2)) {
            $mainChat = $chat2;
        } else {
            $mainChat = Chat::query()->create([
                'user_id' => $data['user_id'],
                'endpoint_user_id' => $data['other_user_id']
            ]);
        }
        unset($data['other_user_id']);
        $data['chat_id'] = $mainChat->getAttribute('id');
        $message = Message::query()->create($data);
        broadcast(new MessageEvent($message));
    }

    /**
     * @param $user1_id
     * @param $user2_id
     * @return Model|Builder|null
     */
    protected function messageChat($user1_id, $user2_id): Model|Builder|null
    {
        return Chat::query()
            ->where('user_id', $user1_id)
            ->where('endpoint_user_id', $user2_id)
            ->first();
    }

    /**
     * @param MessageRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(MessageRequest $request, $id)
    {
        $data = filterRequest($request->validated());
        $this->checkRequestValidity($data);
        $this->handleRequestFile($data);
        $message = $this->messageRepository->findOneById($id);
        if ($message->getAttribute('user_id') != currentUser()->getAttribute('id')) {
            throw new CustomException(trans('messages.UNAUTHORIZED_CHAT_USER'));
        }
        $message->update($data);
        broadcast(new MessageEvent($message));
    }


    /**
     * @param $id
     * @throws CustomException
     */
    public function delete($id)
    {
        $messageToBeDeleted = $this->messageRepository->findOneById($id);
        if ($messageToBeDeleted->getAttribute('user_id') != currentUser()->getAttribute('id')) {
            throw new CustomException(trans('messages.UNAUTHORIZED_CHAT_USER'));
        }
        $messageToBeDeleted->delete();
    }

    /**
     * @param MessageReplyRequest $request
     * @throws CustomException
     */
    public function reply(MessageReplyRequest $request)
    {
        $data = filterRequest($request->validated());
        $this->checkRequestValidity($data);
        $data['chat_id'] = $this->messageRepository->findOneById($data['message_id'])->getAttribute('chat_id');
        $data['user_id'] = currentUser()->getAttribute('id');
        $chat = Chat::query()->find($data['chat_id']);
        $this->chatIsForThisUser($chat);
        $this->handleRequestFile($data);
        $message = Message::query()->create($data);
        broadcast(new MessageEvent($message));
    }

    /**
     * @param MessageForwardRequest $request
     * @throws CustomException
     */
    public function forward(MessageForwardRequest $request)
    {
        $data = $request->validated();
        $message = $this->messageRepository->findOneById($data['message_id']);
        $chat = Chat::query()->find($data['chat_id']);
        $this->chatIsForThisUser($chat);
        $createdMessage = Message::query()->create([
            'chat_id' => $chat->getAttribute('id'),
            'text' => $message->getAttribute('text'),
            'media' => $message->getAttribute('media'),
            'user_id' => currentUser()->getAttribute('id'),
            'message_id' => $message->getAttribute('message_id')
        ]);
        broadcast(new MessageEvent($createdMessage));
    }

    /**
     * Checks if request body contains oth media and text
     *
     * @param $data
     * @throws CustomException
     */
    protected function checkRequestValidity($data)
    {
        if (!exists($data['text']) && !exists($data['media'])) {
            throw new CustomException(trans('messages.MEDIA_OR_TEXT_REQUIRED'));
        }
    }

    /**
     * @param $data
     * @return void
     */
    protected function handleRequestFile(&$data): void
    {
        $path = handleFile('/message-files', $data['media']);
        $data['media'] = $path;
    }

    /**
     * @param Chat $chat
     * @return array
     * @throws CustomException
     */
    #[ArrayShape([
        'messages' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"
    ])]
    public function chatMessages(Chat $chat): array
    {
        $this->chatIsForThisUser($chat);
        $messages = $chat->messages()->get();
        return [
            'messages' => MessageResource::collection($messages)
        ];
    }

    /**
     * @param $chat
     * @throws CustomException
     */
    protected function chatIsForThisUser($chat)
    {
        $user_id = currentUser()->getAttribute('id');
        if ($chat->user_id != $user_id && $chat->endpoint_user_id != $user_id) {
            throw new CustomException(trans('messages.CHAT_NOT_FOR_THIS_USER'));
        }
    }
}
