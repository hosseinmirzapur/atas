<?php


namespace App\Repository\Structure;

use App\Models\Profile;
use App\Repository\Core\CoreRepository as Repo;


class ProfileRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Profile::class);
    }
}
