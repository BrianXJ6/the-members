<?php

namespace App\Dto;

use App\Models\{
    User,
    Topic,
};

class SubscriptionsTopicDto extends BaseDto
{
    /**
     * Create a new Admin Create User Dto instance
     *
     * @param string $email
     * @param \App\Models\Topic $topic
     * @param null|\App\Models\User $user
     */
    public function __construct(
        public readonly string $email,
        public readonly Topic $topic,
        public readonly ?User $user = null,
    ) {
        //
    }
}
