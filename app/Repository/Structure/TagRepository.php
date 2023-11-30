<?php


namespace App\Repository\Structure;

use App\Models\Tag;
use App\Repository\Core\CoreRepository as Repo;


class TagRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Tag::class);
    }
}
