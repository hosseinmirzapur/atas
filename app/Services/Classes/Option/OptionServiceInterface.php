<?php

namespace App\Services\Classes\Option;

use App\Exceptions\CustomException;
use App\Http\Requests\OptionRequest;

interface OptionServiceInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param OptionRequest $request
     * @throws CustomException
     */
    public function create(OptionRequest $request);

    /**
     * @param OptionRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(OptionRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);
}
