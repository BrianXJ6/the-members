<?php

namespace App\Repositories;

use App\Models\{
    User,
    Topic,
};

class UserRepository extends BaseRepository
{
    /** @inheritdoc */
    public function modelClass(): string
    {
        return User::class;
    }

    /**
     * Check if user is already subscribed to a specific topic
     *
     * @param \App\Models\User $user
     * @param \App\Models\Topic $topic
     *
     * @return bool
     */
    public function checkUserAlreadySubscribedInTopic(User $user, Topic $topic): bool
    {
        return $user->topics->contains($topic);
    }

    /**
     * Subscribe user to the specific topic
     *
     * @param \App\Models\User $user
     * @param \App\Models\Topic $topic
     *
     * @return void
     */
    public function subscriptionUserInTopic(User $user, Topic $topic): void
    {
        $user->topics()->attach($topic);
    }

    /**
     * Unsubscribe user to the specific topic
     *
     * @param \App\Models\Topic $topic
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function unsubscribeByAdmin(Topic $topic, User $user): void
    {
        $user->topics()->detach($topic);
    }
}
