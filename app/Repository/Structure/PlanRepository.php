<?php


namespace App\Repository\Structure;

use App\Models\Plan;
use App\Repository\Core\CoreRepository as Repo;


class PlanRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Plan::class);
    }
}
