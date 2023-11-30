<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class PlanRequest extends FormRequest
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
    #[ArrayShape(['label' => "string", 'price' => "string", 'image' => "string[]"])] public function postRules(): array
    {
        return [
            'label' => 'required',
            'price' => 'required',
            'image' => ['required', 'mimes:jpeg,png,jpg,gif']
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['label' => "string", 'price' => "string", 'image' => "string[]"])] public function putRules(): array
    {
        return [
            'label' => 'nullable',
            'price' => 'nullable',
            'image' => ['nullable', 'mimes:jpeg,png,jpg,gif']
        ];
    }
}
