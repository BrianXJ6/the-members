<?php

namespace App\Http\Requests;

use App\Models\Topic;
use App\Dto\StoreTopicDto;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(Topic::class)]
        ];
    }

    /**
     * Get data from request (DTO)
     *
     * @return \App\Dto\StoreTopicDto
     */
    public function data(): StoreTopicDto
    {
        return new StoreTopicDto(
            ...$this->safe()->merge(['admin' => $this->user()])
        );
    }
}
