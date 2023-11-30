<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\AddNetworkToPayMethodRequest;
use App\Http\Requests\UpdateNetworkRequest;
use App\Services\Classes\Network\NetworkServiceInterface;
use Illuminate\Http\JsonResponse;

class NetworkController extends Controller
{
    protected NetworkServiceInterface $service;

    public function __construct(NetworkServiceInterface $service)
    {
        $this->middleware('only-admin');
        $this->service = $service;
    }

    /**
     * @param AddNetworkToPayMethodRequest $request
     * @return JsonResponse
     * @throws CustomException
     */
    public function add(AddNetworkToPayMethodRequest $request): JsonResponse
    {
        $this->service->addNetworkToPayMethod($request);
        return jsonResponse();
    }

    /**
     * @param UpdateNetworkRequest $request
     * @param $id
     * @return JsonResponse
     * @throws CustomException
     */
    public function update(UpdateNetworkRequest $request, $id): JsonResponse
    {
        $this->service->update($request, $id);
        return jsonResponse();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);
        return jsonResponse();
    }
}
