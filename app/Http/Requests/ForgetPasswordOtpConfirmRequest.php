<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ForgetPasswordOtpConfirmRequest extends FormRequest
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
    #[ArrayShape(['token' => "string", 'email' => "string", 'code' => "string"])] public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required',
            'code' => 'required'
        ];
    }
}
