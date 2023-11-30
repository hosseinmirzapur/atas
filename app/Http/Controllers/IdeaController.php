<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeIdeaRequest;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\Services\Classes\Idea\IdeaServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    protected IdeaServiceInterface $service;

    public function __construct(IdeaServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(Request $request): JsonResponse
    {
        return jsonResponse($this->service->allForUser($request));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return jsonResponse($this->service->show($id));
    }

    /**
     * @param IdeaRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(IdeaRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
    }

    /**
     * @param UpdateIdeaRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(UpdateIdeaRequest $request, $id): JsonResponse
    {
        $this->service->update($request, $id);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }

    /**
     * @param ChangeIdeaRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function changeStatus(ChangeIdeaRequest $request): JsonResponse
    {
        $this->service->changeStatus($request);
        return jsonResponse();
    }
}
