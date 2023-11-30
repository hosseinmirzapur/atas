<?php


namespace App\Repository\Structure;

use App\Models\PaymentMethod;
use App\Repository\Core\CoreRepository as Repo;


class PaymentMethodRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(PaymentMethod::class);
    }
}
