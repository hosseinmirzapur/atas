<?php

namespace App\Services\Classes\Billing;

use App\Exceptions\CustomException;
use App\Http\Requests\ChangeBillingStatusRequest;
use App\Http\Requests\PayRequest;

interface BillingServiceInterface
{
    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param PayRequest $request
     * @throws CustomException
     */
    public function pay(PayRequest $request);

    public function changeBillingStatus(ChangeBillingStatusRequest $request);
}
