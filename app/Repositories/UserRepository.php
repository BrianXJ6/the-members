<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /** @inheritdoc */
    public function modelClass(): string
    {
        return User::class;
    }
}
