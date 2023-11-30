<?php


namespace App\Repository\Structure;

use App\Models\AboutUs;
use App\Repository\Core\CoreRepository as Repo;


class AboutUsRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(AboutUs::class);
    }

}
