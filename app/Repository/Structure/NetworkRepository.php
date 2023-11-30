<?php


namespace App\Repository\Structure;

use App\Models\Network;
use App\Repository\Core\CoreRepository as Repo;


class NetworkRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Network::class);
    }
}
