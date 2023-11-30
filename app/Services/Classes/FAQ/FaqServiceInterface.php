<?php

namespace App\Services\Classes\FAQ;

use App\Http\Requests\FaqRequest;

interface FaqServiceInterface
{
    /**
     * @return array
     */
    public function showLast(): array;

    /**
     * @param FaqRequest $request
     */
    public function createNew(FaqRequest $request);
}
