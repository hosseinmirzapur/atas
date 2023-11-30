<?php


namespace App\Repository\Structure;

use App\Models\Report;
use App\Repository\Core\CoreRepository as Repo;


class ReportRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Report::class);
    }
}
