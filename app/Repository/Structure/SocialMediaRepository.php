<?php


namespace App\Repository\Structure;

use App\Models\SocialMedia;
use App\Repository\Core\CoreRepository as Repo;

class SocialMediaRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(SocialMedia::class);
    }
}
