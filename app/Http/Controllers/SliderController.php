<?php

namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Requests\SliderRequest;
use App\Services\Classes\Slider\SliderServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected SliderServiceInterface $service;

    /**
     * SliderController constructor.
     * @param SliderServiceInterface $service
     */
    public function __construct(SliderServiceInterface $service)
    {
        $this->service = $service;
        $this->middleware('only-admin')->except(['index', 'show']);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(Request $request): JsonResponse
    {
        return jsonResponse($this->service->all($request));
    }

    /**
     * @param SliderRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function store(SliderRequest $request): JsonResponse
    {
        $this->service->create($request);
        return jsonResponse();
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
     * @param SliderRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(SliderRequest $request, $id): JsonResponse
    {
        $this->service->update($request, $id);
        return jsonResponse();
    }

    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }
}
