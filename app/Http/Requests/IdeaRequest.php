<?php

namespace App\Http\Requests;

use App\Models\Idea;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class IdeaRequest extends FormRequest
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
        return [
            'type1' => ['required', Rule::in(Idea::TYPE1)],
            'type2' => ['required', Rule::in(Idea::TYPE2)],
            'title' => 'required',
            'caption' => 'required',
            'related_link' => 'required',
            'tags' => 'required',
            'private' => ['required', 'boolean'],
            'strategy' => ['required', Rule::in(Idea::INVESTMENT_STRATEGY)],
            'category' => 'required',
            'time_frame' => 'required',
            'file' => ['required', File::types(['image', 'video'])],
            'coin_id' => 'required'
        ];
    }
}
