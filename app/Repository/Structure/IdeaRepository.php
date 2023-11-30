<?php


namespace App\Repository\Structure;

use App\Models\Idea;
use App\Repository\Core\CoreRepository as Repo;


class IdeaRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Idea::class);
    }
}
