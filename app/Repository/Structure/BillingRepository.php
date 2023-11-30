<?php


namespace App\Repository\Structure;

use App\Models\Billing;
use App\Repository\Core\CoreRepository as Repo;


class BillingRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Billing::class);
    }
}
