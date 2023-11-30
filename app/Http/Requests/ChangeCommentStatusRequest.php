<?php

namespace App\Http\Requests;

use App\Classes\MainComment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ChangeCommentStatusRequest extends FormRequest
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
    #[ArrayShape(['status' => "array", 'comment_id' => "string"])] public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(MainComment::STATUS)],
            'comment_id' => 'required'
        ];
    }
}
