<?php


namespace App\Repository\Structure;

use App\Models\Market;
use App\Repository\Core\CoreRepository as Repo;


class MarketRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Market::class);
    }
}
