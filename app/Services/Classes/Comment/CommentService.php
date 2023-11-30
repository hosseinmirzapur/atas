<?php


namespace App\Services\Classes\Comment;


use App\Http\Requests\ChangeCommentStatusRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Idea;
use App\Repository\Structure\CommentRepository;
use App\Repository\Structure\IdeaRepository;

class CommentService implements CommentServiceInterface
{
    protected CommentRepository $commentRepository;
    protected IdeaRepository $ideaRepository;

    public function __construct(CommentRepository $commentRepository, IdeaRepository $ideaRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->ideaRepository = $ideaRepository;
    }

    /**
     * @param CommentRequest $request
     */
    public function onIdeaOrNews(CommentRequest $request)
    {
        $user = currentUser();
        $ideaOrNews = $this->ideaRepository->findOneById($request->commentable_id);
        $this->commentRepository->createOne([
            'text' => $request->text,
            'user_id' => $user->id,
            'commentable_id' => $ideaOrNews->id,
            'commentable_type' => Idea::class
        ]);
    }

    /**
     * @param CommentRequest $request
     * @param $commentId
     */
    public function reply(CommentRequest $request, $commentId)
    {
        $user = currentUser();
        $ideaOrNews = $this->ideaRepository->findOneById($request->commentable_id);
        $comment = $this->commentRepository->findOneById($commentId);
        $this->commentRepository->createOne([
            'text' => $request->text,
            'user_id' => $user->id,
            'commentable_id' => $ideaOrNews->id,
            'commentable_type' => Idea::class,
            'related_comment_id' => $comment->id
        ]);
    }

    /**
     * @param CommentRequest $request
     */
    public function update(CommentRequest $request)
    {
        // todo: Check the changing timeout limit & implement this method
        $this->commentRepository->updateById($request->commentable_id, [
            'text' => $request->text
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        // todo: same as above todo
        $this->commentRepository->deleteById($id);
    }

    /**
     * @param ChangeCommentStatusRequest $request
     */
    public function updateStatus(ChangeCommentStatusRequest $request)
    {
        $this->commentRepository->updateById($request->comment_id, [
            'status' => $request->status
        ]);
    }
}
