<?php


namespace App\Repository\Structure;

use App\Classes\MainBookmark;
use App\Repository\Core\CoreRepository as Repo;


class BookmarkRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(MainBookmark::class);
    }
}
