<?php


namespace App\Repository\Structure;

use App\Models\Option;
use App\Repository\Core\CoreRepository as Repo;


class OptionRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Option::class);
    }
}
