<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class MessageRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape([
        'text' => "string",
        'media' => "string",
        'other_user_id' => "array"
    ])]
    public function postRules(): array
    {
        return [
            'text' => 'sometimes',
            'media' => ['sometimes', 'file'],
            'other_user_id' => ['required', Rule::exists('users', 'id')]
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['text' => "string", 'media' => "string[]"])] public function putRules(): array
    {
        return [
            'text' => 'sometimes',
            'media' => ['sometimes', 'file']
        ];
    }
}
