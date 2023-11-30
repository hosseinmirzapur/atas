<?php

namespace App\Http\Requests;

use App\Models\Announcement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class AnnouncementRequest extends FormRequest
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
    #[ArrayShape(['type' => "array", 'title' => "string", 'text' => "string"])] public function postRules(): array
    {
        return [
            'type' => ['required', Rule::in(Announcement::TYPE)],
            'title' => 'required',
            'text' => 'required'
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['type' => "array", 'title' => "string", 'text' => "string"])] public function putRules(): array
    {
        return [
            'type' => ['nullable', Rule::in(Announcement::TYPE)],
            'title' => 'nullable',
            'text' => 'nullable'
        ];
    }
}
