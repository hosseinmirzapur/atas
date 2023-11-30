<?php

namespace App\Http\Requests;

use App\Models\Network;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UpdateNetworkRequest extends FormRequest
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
    #[ArrayShape(['label' => "string", 'address' => "string", 'status' => "array"])] public function rules(): array
    {
        return [
            'label' => 'nullable',
            'address' => 'nullable',
            'status' => ['nullable', Rule::in(Network::STATUS)]
        ];
    }
}
