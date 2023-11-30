<?php

namespace App\Services\Classes\Idea;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeIdeaRequest;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use Illuminate\Http\Request;

interface IdeaServiceInterface
{
    /**
     * @throws CustomException
     */
    public function allForUser(Request $request): array;

    /**
     * @param $id
     * @return array
     */
    public function show($id): array;

    /**
     * @param IdeaRequest $request
     * @throws CustomException
     */
    public function create(IdeaRequest $request);

    /**
     * @param UpdateIdeaRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateIdeaRequest $request, $id);

    /**
     * @param $id
     * @throws CustomException
     */
    public function delete($id);

    /**
     * @param ChangeIdeaRequest $request
     * @throws CustomException
     */
    public function changeStatus(ChangeIdeaRequest $request);
}
