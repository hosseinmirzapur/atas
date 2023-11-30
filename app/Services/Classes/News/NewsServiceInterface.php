<?php

namespace App\Services\Classes\News;

use App\Exceptions\CustomException;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;

interface NewsServiceInterface
{
    /**
     * @throws CustomException
     */
    public function allForAdmin(Request $request): array;

    /**
     * @param $id
     * @return array
     */
    public function show($id): array;

    /**
     * @throws CustomException
     */
    public function create(IdeaRequest $request);

    /**
     * @param UpdateNewsRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateNewsRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);

    /**
     * @param Request $request
     * @return array
     * @throws CustomException
     */
    public function forUsers(Request $request): array;
}
