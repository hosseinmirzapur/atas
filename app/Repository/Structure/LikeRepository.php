<?php


namespace App\Repository\Structure;

use App\Classes\MainLike;
use App\Repository\Core\CoreRepository as Repo;


class LikeRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(MainLike::class);
    }
}
