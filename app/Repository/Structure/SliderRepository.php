<?php


namespace App\Repository\Structure;

use App\Models\Slider;
use App\Repository\Core\CoreRepository as Repo;


class SliderRepository extends Repo
{
    public function __construct()
    {
        parent::__construct(Slider::class);
    }
}
