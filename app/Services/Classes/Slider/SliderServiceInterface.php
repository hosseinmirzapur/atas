<?php

namespace App\Services\Classes\Slider;

use App\Exceptions\CustomException;
use App\Http\Requests\SliderRequest;
use Illuminate\Http\Request;

interface SliderServiceInterface
{
    /**
     * @param Request $request
     * @return array
     * @throws CustomException
     */
    public function all(Request $request): array;

    /**
     * @param SliderRequest $request
     * @throws CustomException
     */
    public function create(SliderRequest $request);

    /**
     * @param $id
     * @return array
     */
    public function show($id): array;

    /**
     * @param SliderRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(SliderRequest $request, $id);

    public function delete($id);
}
