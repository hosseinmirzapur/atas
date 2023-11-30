<?php


namespace App\Repository\Structure;

use App\Models\Strategy;
use App\Repository\Core\CoreRepository as Repo;


class StrategyRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Strategy::class);
    }
}
