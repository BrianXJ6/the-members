<?php

namespace App\Http\Requests;

use App\Dto\SendMessageDto;
use Illuminate\Foundation\Http\FormRequest;

class UserSendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->topics->contains($this->topic);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string'],
        ];
    }

    /**
     * Get data from request (DTO)
     *
     * @return \App\Dto\SendMessageDto
     */
    public function data(): SendMessageDto
    {
        return new SendMessageDto(
            ...$this->safe()->merge(['messageable' => $this->user()])
        );
    }
}
