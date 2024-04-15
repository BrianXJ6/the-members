<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Dto\AdminCreateUserDto;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdminCreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique(User::class)],
        ];
    }

    /**
     * get data from request (DTO)
     *
     * @return \App\Dto\AdminCreateUserDto
     */
    public function data(): AdminCreateUserDto
    {
        return new AdminCreateUserDto(...$this->validated());
    }
}
