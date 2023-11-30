<?php


namespace App\Repository\Structure;

use App\Models\Comment;
use App\Repository\Core\CoreRepository as Repo;


class CommentRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Comment::class);
    }
}
