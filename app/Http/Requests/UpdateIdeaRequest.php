<?php

namespace App\Http\Requests;

use App\Repository\Structure\IdeaRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIdeaRequest extends FormRequest
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
        $ideaRepository = new IdeaRepository();
        $idea = $ideaRepository->findOneById($this->route('id'));
        if ($idea->isPrivate()) {
            return [
                'link' => 'sometimes',
                'tags' => 'sometimes',
                'title' => 'sometimes',
                'description' => 'sometimes'
            ];
        }
        return $this->getFillableFields($idea->created_at);
    }

    protected function getFillableFields(string $created_at): array
    {
        $fillable = [
            'link' => 'sometimes',
            'tags' => 'sometimes'
        ];
        if (now()->diffInMinutes($created_at) >= 15) {
            return $fillable;
        }
        return $fillable + [
                'title' => 'sometimes',
                'description' => 'sometimes'
            ];
    }
}
