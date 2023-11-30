<?php


namespace App\Repository\Structure;

use App\Models\Announcement;
use App\Repository\Core\CoreRepository as Repo;


class AnnouncementRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Announcement::class);
    }
}
