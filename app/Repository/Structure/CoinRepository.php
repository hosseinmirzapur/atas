<?php


namespace App\Repository\Structure;

use App\Models\Coin;
use App\Repository\Core\CoreRepository as Repo;


class CoinRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Coin::class);
    }
}
