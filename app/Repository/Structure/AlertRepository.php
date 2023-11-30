<?php


namespace App\Repository\Structure;

use App\Models\Alert;
use App\Repository\Core\CoreRepository as Repo;


class AlertRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Alert::class);
    }
}
