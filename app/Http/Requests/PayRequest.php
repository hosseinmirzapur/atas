<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class PayRequest extends FormRequest
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
    #[ArrayShape(['plan_id' => "array", 'payment_method_id' => "array", 'network_id' => "array", 'tx_id' => "string"])] public function rules(): array
    {
        return [
            'plan_id' => ['required', Rule::exists('plans', 'id')],
            'payment_method_id' => ['required', Rule::exists('payment_methods', 'id')],
            'network_id' => ['required', Rule::in('networks', 'id')],
            'tx_id' => 'required'
        ];
    }
}
