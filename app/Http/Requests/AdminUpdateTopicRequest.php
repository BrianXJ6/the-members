<?php

namespace App\Http\Requests;

use App\Models\Topic;
use App\Dto\UpdateTopicDto;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->topic->admin()->is($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(Topic::class)->ignore($this->topic->id)]
        ];
    }

    /**
     * Get data from request (DTO)
     *
     * @return \App\Dto\UpdateTopicDto
     */
    public function data(): UpdateTopicDto
    {
        return new UpdateTopicDto(...$this->validated());
    }
}
