<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class RegisterRequest extends FormRequest
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
    #[ArrayShape(['email' => "array", 'password' => "string", 'invitation_code' => "string"])] public function rules(): array
    {
        return [
            'email' => ['required', Rule::unique('users', 'email')->whereNot('status', 'FRESH')],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'invitation_code' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'password' => trans('validation.INVALID_PASSWORD')
        ];
    }
}
