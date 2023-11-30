<?php


namespace App\Repository\Structure;

use App\Models\Follow;
use App\Repository\Core\CoreRepository as Repo;

class FollowRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Follow::class);
    }
}
