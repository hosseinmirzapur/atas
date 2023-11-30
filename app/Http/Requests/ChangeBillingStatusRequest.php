<?php

namespace App\Http\Requests;

use App\Models\Billing;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ChangeBillingStatusRequest extends FormRequest
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
    #[ArrayShape(['billing_id' => "array", 'status' => "array"])] public function rules(): array
    {
        return [
            'billing_id' => ['required', Rule::exists('billings', 'id')],
            'status' => ['required', Rule::in(Billing::STATUS)]
        ];
    }
}
