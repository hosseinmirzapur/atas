<?php


namespace App\Repository\Structure;

use App\Models\Rank;
use App\Repository\Core\CoreRepository as Repo;


class RankRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Rank::class);
    }
}
