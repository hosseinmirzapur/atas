<?php


namespace App\Repository\Structure;

use App\Models\Chat;
use App\Repository\Core\CoreRepository as Repo;


class ChatRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Chat::class);
    }
}
