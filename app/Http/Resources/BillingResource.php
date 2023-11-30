<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'email' => $this->user->email
            ],
            'plan' => PlanResource::make($this->plan),
            'network' => NetworkResource::make($this->network),
            'payment_method' => PaymentMethodResource::make()
        ];
    }
}
