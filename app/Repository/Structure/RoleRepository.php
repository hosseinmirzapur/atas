<?php


namespace App\Repository\Structure;

use App\Models\Role;
use App\Repository\Core\CoreRepository as Repo;


class RoleRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Role::class);
    }
}
