<?php


namespace App\Services\Classes\Network;


use App\Exceptions\CustomException;
use App\Http\Requests\AddNetworkToPayMethodRequest;
use App\Http\Requests\UpdateNetworkRequest;
use App\Repository\Structure\NetworkRepository;

class NetworkService implements NetworkServiceInterface
{
    protected NetworkRepository $networkRepository;

    public function __construct(NetworkRepository $networkRepository)
    {
        $this->networkRepository = $networkRepository;
    }

    /**
     * @param AddNetworkToPayMethodRequest $request
     * @throws CustomException
     */
    public function addNetworkToPayMethod(AddNetworkToPayMethodRequest $request)
    {
        $this->networkRepository->createOne($request->validated());
    }

    /**
     * @param UpdateNetworkRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateNetworkRequest $request, $id)
    {
        $this->networkRepository->updateById($id, $request->validated());
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->networkRepository->deleteById($id);
    }
}
