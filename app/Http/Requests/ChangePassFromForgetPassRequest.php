<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class ChangePassFromForgetPassRequest extends FormRequest
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
    #[ArrayShape(['new_password' => "string", 'confirm_password' => "string", 'email' => "string", 'token' => "string"])] public function rules(): array
    {
        return [
            'new_password' => ['required', Password::min(8)->letters()->numbers()],
            'confirm_password' => 'required',
            'email' => 'required',
            'token' => 'required'
        ];
    }
}
