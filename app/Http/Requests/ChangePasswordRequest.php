<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use JetBrains\PhpStorm\ArrayShape;

class ChangePasswordRequest extends FormRequest
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
    #[ArrayShape(['old_password' => "string", 'new_password' => "string", 'confirm_password' => "string"])] public function rules(): array
    {
        return [
            'old_password' => 'required',
            'new_password' => ['required', Password::min(8)->letters()->numbers()],
            'confirm_password' => 'required'
        ];
    }
}
