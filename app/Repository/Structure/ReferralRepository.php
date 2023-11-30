<?php


namespace App\Repository\Structure;

use App\Models\Referral;
use App\Repository\Core\CoreRepository as Repo;


class ReferralRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Referral::class);
    }
}
