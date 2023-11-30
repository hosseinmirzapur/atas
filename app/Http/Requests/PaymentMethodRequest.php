<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class PaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->isMethod('post') ? $this->postRules() : $this->putRules();
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['label' => "string", 'plan_id' => "string"])] public function postRules(): array
    {
        return [
            'label' => 'required',
            'plan_id' => 'required'
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['label' => "string"])] public function putRules(): array
    {
        return [
            'label' => 'sometimes'
        ];
    }
}
