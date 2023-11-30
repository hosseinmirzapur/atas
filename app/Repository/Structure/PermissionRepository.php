<?php


namespace App\Repository\Structure;

use App\Models\Permission;
use App\Repository\Core\CoreRepository as Repo;


class PermissionRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Permission::class);
    }
}
