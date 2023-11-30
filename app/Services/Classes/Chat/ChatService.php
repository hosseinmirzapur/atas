<?php


namespace App\Services\Classes\Chat;


use App\Exceptions\CustomException;
use App\Http\Requests\StartChatRequest;
use App\Http\Resources\UserChatResource;
use App\Repository\Structure\ChatRepository;
use App\Repository\Structure\UserRepository;
use JetBrains\PhpStorm\ArrayShape;
//use Symfony\Component\Process\Process;

class ChatService implements ChatServiceInterface
{
    protected UserRepository $userRepository;
    protected ChatRepository $chatRepository;

    public function __construct(UserRepository $userRepository, ChatRepository $chatRepository)
    {
        $this->userRepository = $userRepository;
        $this->chatRepository = $chatRepository;
    }

    /**
     * @param StartChatRequest $request
     */
    public function create(StartChatRequest $request)
    {
        $user = currentUser();
        $endUser = $this->userRepository->findOneById($request->get('endpoint_user_id'));
        $user->chats()->updateOrCreate(['endpoint_user_id' => $endUser->getAttribute('id')], [
            'endpoint_user_id' => $endUser->getAttribute('id')
        ]);
    }

    /**
     * @return array
     */
    #[ArrayShape(['chats' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])] public function userChats(): array
    {
        $user = currentUser();
        $chats = $user->chats()->get();
        return [
            'chats' => UserChatResource::collection($chats)
        ];
    }

    /**
     * @param $chatId
     * @throws CustomException
     */
    public function delete($chatId)
    {
        $user = currentUser();
        $chatToBeDeleted = $this->chatRepository->findOneById($chatId);
        if ($chatToBeDeleted->getAttribute('user_id') != $user->getAttribute('id')) {
            throw new CustomException(trans('messages.UNAUTHORIZED_CHAT_USER'));
        }
        $chatToBeDeleted->delete();
    }

//    public function something($cmd)
//    {
//        $process = Process::fromShellCommandline($cmd);
//
//        $processOutput = '';
//
//        $captureOutput = function ($type, $line) use (&$processOutput) {
//            $processOutput .= $line;
//        };
//
//        $process->setTimeout(null)->run($captureOutput);
//
//        return $processOutput;
//    }
}
