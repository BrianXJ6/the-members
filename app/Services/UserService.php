<?php

namespace App\Services;

use App\Models\User;
use App\Dto\SubscriptionsTopicDto;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    /**
     * Create a new User Service instance
     *
     * @param \App\Repositories\UserRepository $userRepository
     */
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * Create User by subscriptions topic
     *
     * @param \App\Dto\SubscriptionsTopicDto $data
     *
     * @return \App\Models\User
     */
    public function subscriptionsByTopic(SubscriptionsTopicDto $data): User
    {
        return $data->user ?: $this->create([
            'name' => 'anonymous User',
            'email' => $data->email,
        ]);
    }
}
