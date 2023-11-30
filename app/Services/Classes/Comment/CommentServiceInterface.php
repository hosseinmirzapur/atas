<?php

namespace App\Services\Classes\Comment;

use App\Http\Requests\ChangeCommentStatusRequest;
use App\Http\Requests\CommentRequest;

interface CommentServiceInterface
{
    /**
     * @param CommentRequest $request
     */
    public function onIdeaOrNews(CommentRequest $request);

    /**
     * @param CommentRequest $request
     * @param $commentId
     */
    public function reply(CommentRequest $request, $commentId);

    /**
     * @param CommentRequest $request
     */
    public function update(CommentRequest $request);

    /**
     * @param $id
     */
    public function delete($id);

    /**
     * @param ChangeCommentStatusRequest $request
     */
    public function updateStatus(ChangeCommentStatusRequest $request);
}
