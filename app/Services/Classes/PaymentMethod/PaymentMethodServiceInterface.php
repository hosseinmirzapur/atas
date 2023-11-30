<?php

namespace App\Services\Classes\PaymentMethod;

use App\Exceptions\CustomException;
use App\Http\Requests\PaymentMethodRequest;

interface PaymentMethodServiceInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @throws CustomException
     */
    public function create(PaymentMethodRequest $request);

    /**
     * @param $id
     * @return array
     */
    public function find($id): array;

    /**
     * @throws CustomException
     */
    public function update(PaymentMethodRequest $request, $id);

    /**
     * @param $id
     */
    public function delete($id);
}
