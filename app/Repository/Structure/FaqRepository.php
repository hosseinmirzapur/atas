<?php


namespace App\Repository\Structure;

use App\Models\Faq;
use App\Repository\Core\CoreRepository as Repo;


class FaqRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Faq::class);
    }
}
