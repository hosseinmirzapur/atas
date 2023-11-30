<?php


namespace App\Services\Classes\Like;


use App\Http\Requests\LikeRequest;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\Like;
use App\Models\Message;
use App\Repository\Structure\CommentRepository;
use App\Repository\Structure\IdeaRepository;
use App\Repository\Structure\LikeRepository;
use App\Repository\Structure\MessageRepository;

class LikeService implements LikeServiceInterface
{
    protected CommentRepository $commentRepository;
    protected IdeaRepository $ideaRepository;
    protected LikeRepository $likeRepository;
    protected MessageRepository $messageRepository;

    public function __construct(CommentRepository $commentRepository,
                                IdeaRepository $ideaRepository,
                                MessageRepository $messageRepository,
                                LikeRepository $likeRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->ideaRepository = $ideaRepository;
        $this->likeRepository = $likeRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param LikeRequest $request
     */
    public function likeComment(LikeRequest $request)
    {
        $user = currentUser();
        $comment = $this->commentRepository->findOneById($request->likeable_id);
        $like = Like::query()
            ->where('likeable_id', $comment->id)
            ->where('likeable_type', Comment::class)
            ->where('user_id', $user->id)
            ->first();
        if (exists($like)) {
            $this->likeRepository->forceDeleteById($like->id);
        } else {
            $this->likeRepository->createOne([
                'likeable_id' => $request->likeable_id,
                'likeable_type' => Comment::class,
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * @param LikeRequest $request
     */
    public function likeIdeaOrNews(LikeRequest $request)
    {
        $user = currentUser();
        $idea = $this->ideaRepository->findOneById($request->likeable_id);
        $like = Like::query()
            ->where('likeable_id', $idea->id)
            ->where('likeable_type', Idea::class)
            ->where('user_id', $user->id)
            ->first();
        if (exists($like)) {
            $this->likeRepository->forceDeleteById($like->id);
        } else {
            $this->likeRepository->createOne([
                'likeable_id' => $request->likeable_id,
                'likeable_type' => Idea::class,
                'user_id' => $user->id
            ]);
        }
    }

    public function likeMessage(LikeRequest $request)
    {
        $user = currentUser();
        $message = $this->messageRepository->findOneById($request->likeable_id);
        $like = Like::query()
            ->where('likeable_id', $message->id)
            ->where('likeable_type', Message::class)
            ->where('user_id', $user->id)
            ->first();
        if (exists($like)) {
            $this->likeRepository->forceDeleteById($like->id);
        } else {
            $this->likeRepository->createOne([
                'likeable_id' => $request->likeable_id,
                'likeable_type' => Message::class,
                'user_id' => $user->id
            ]);
        }
    }
}
