<?php


namespace App\Repository\Structure;

use App\Models\Admin;
use App\Repository\Core\CoreRepository as Repo;


class AdminRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Admin::class);
    }
}
