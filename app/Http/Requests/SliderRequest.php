<?php

namespace App\Http\Requests;

use App\Models\Slider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class SliderRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'data' => "string", 'image' => "string[]", 'type' => "string[]"])] public function postRules(): array
    {
        return [
            'title' => 'required',
            'data' => 'required',
            'image' => ['required', 'mimes:jpeg,png,jpg,gif'],
            'type' => ['required', Rule::in(Slider::TYPE)]
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['title' => "string", 'data' => "string", 'image' => "string[]", 'type' => "string[]"])] public function putRules(): array
    {
        return [
            'title' => 'nullable',
            'data' => 'nullable',
            'image' => ['sometimes', 'mimes:jpeg,png,jpg,gif'],
            'type' => ['nullable', Rule::in(Slider::TYPE)]
        ];
    }
}
