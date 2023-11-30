<?php

namespace App\Services\Classes\Network;

use App\Exceptions\CustomException;
use App\Http\Requests\AddNetworkToPayMethodRequest;
use App\Http\Requests\UpdateNetworkRequest;

interface NetworkServiceInterface
{
    /**
     * @param AddNetworkToPayMethodRequest $request
     * @throws CustomException
     */
    public function addNetworkToPayMethod(AddNetworkToPayMethodRequest $request);

    /**
     * @param UpdateNetworkRequest $request
     * @param $id
     * @throws CustomException
     */
    public function update(UpdateNetworkRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);
}
