<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Dto\SubscriptionsTopicDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class SubscriptionsTopicRequest extends FormRequest
{
    /**
     * User for subscriptions
     *
     * @var null|\App\Models\User
     */
    private ?User $user = null;

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('email'))
            $this->user = User::where('email', $this->email)->first();

        if (!is_null($this->user) && $this->checkPivot())
            throw new AuthorizationException(__('validation.unique', ['attribute' => 'email']));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email']
        ];
    }

    /**
     * Check if there is a pivot between user and topic
     *
     * @return bool
     */
    private function checkPivot(): bool
    {
        if (is_null($this->user)) return false;

        return $this->user->topics()
            ->wherePivot('topic_id', $this->topic->id)
            ->exists();
    }

    /**
     * Get data from request (DTO)
     *
     * @return \App\Dto\SubscriptionsTopicDto
     */
    public function data(): SubscriptionsTopicDto
    {
        return new SubscriptionsTopicDto(
            ...$this->safe()->merge([
                'user' => $this->user,
                'topic' => $this->topic,
            ])
        );
    }
}
