<?php

namespace App\Http\Requests;

use App\Models\Idea;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ChangeIdeaRequest extends FormRequest
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
    #[ArrayShape(['idea_id' => "array", 'status' => "array"])] public function rules(): array
    {
        return [
            'idea_id' => ['required', Rule::exists('ideas', 'id')],
            'status' => ['required', Rule::in(Idea::STATUS)]
        ];
    }
}
