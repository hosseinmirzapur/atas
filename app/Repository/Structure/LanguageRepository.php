<?php


namespace App\Repository\Structure;

use App\Models\Language;
use App\Repository\Core\CoreRepository as Repo;


class LanguageRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Language::class);
    }
}
