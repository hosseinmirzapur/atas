<?php


namespace App\Repository\Structure;

use App\Models\Message;
use App\Repository\Core\CoreRepository as Repo;


class MessageRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Message::class);
    }
}
