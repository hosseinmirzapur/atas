<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        $user = currentUser();
        $user_name = $user->profile->user_name ?? null;
        return [
            'photo' => ['nullable', 'mimes:jpeg,png,jpg,gif'],
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'user_name'=> ['nullable', Rule::unique('profiles', 'user_name')->whereNot('user_name', $user_name)],
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip_code' => 'nullable',
            'phone_number' => 'nullable',
            'about_me' => 'nullable',
            'show_status' => ['nullable', 'boolean'],
            'instagram' => 'nullable',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'website' => 'nullable',
            'youtube_username' => 'nullable',
            'youtube_channel' => 'nullable',
            'signature' => 'nullable',
            'social_in_signature' => 'nullable|boolean'
        ];
    }
}
