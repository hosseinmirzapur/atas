<?php


namespace App\Repository\Structure;

use App\Models\Term;
use App\Repository\Core\CoreRepository as Repo;


class TermRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Term::class);
    }
}
