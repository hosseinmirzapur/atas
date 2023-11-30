<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class AddNetworkToPayMethodRequest extends FormRequest
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
    #[ArrayShape(['label' => "string", 'address' => "string", 'payment_method_id' => "array"])] public function rules(): array
    {
        return [
            'label' => 'required',
            'address' => 'required',
            'payment_method_id' => ['required', Rule::exists('payment_methods', 'id')]
        ];
    }
}
