<?php


namespace App\Repository\Structure;

use App\Models\User;
use App\Repository\Core\CoreRepository as Repo;

class UserRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

}
