<?php


namespace App\Repository\Structure;

use App\Models\GMessage;
use App\Repository\Core\CoreRepository as Repo;

class GMessageRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(GMessage::class);
    }
}
