<?php

namespace App\Http\Requests;

use App\Models\Idea;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;


class UpdateNewsRequest extends FormRequest
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
            'idea_file' => ['sometimes', File::types(['image', 'video'])],
            'title' => 'sometimes',
            'description' => 'sometimes',
            'link' => 'sometimes',
            'category'=> 'sometimes',
            'idea_first_type' => ['sometimes', Rule::in(Idea::TYPE1)],
            'idea_second_type' => ['sometimes', Rule::in(Idea::TYPE2)],
            'investment_strategy' => ['sometimes', Rule::in(Idea::INVESTMENT_STRATEGY)],
            'time_frame' => 'sometimes',
            'coin_id' => ['sometimes', Rule::exists('coins', 'id')],
            'status' => ['sometimes', Rule::in(Idea::STATUS)],
            'tags' => 'sometimes'
        ];
    }
}
