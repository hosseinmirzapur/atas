<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class MessageForwardRequest extends FormRequest
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
    #[ArrayShape(['chat_id' => "array", 'message_id' => "array"])] public function rules(): array
    {
        return [
            'chat_id' => ['required', Rule::exists('chats', 'id')],
            'message_id' => ['required', Rule::exists('messages', 'id')]
        ];
    }
}
