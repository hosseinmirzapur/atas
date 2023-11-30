<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class MessageReplyRequest extends FormRequest
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

    #[ArrayShape([
        'message_id' => "array",
        'text' => "string",
        'media' => "string[]",
    ])]
    public function rules(): array
    {
        return [
            'message_id' => ['required', Rule::exists('messages', 'id')],
            'text' => 'sometimes',
            'media' => ['sometimes', 'file'],
        ];
    }
}
