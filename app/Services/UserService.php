<?php

namespace App\Services;

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
}
