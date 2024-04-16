<?php

namespace App\Repositories;

use App\Models\{
    User,
    Topic,
};

use App\Dto\StoreTopicDto;
use Illuminate\Support\Collection;

class TopicRepository extends BaseRepository
{
    /** @inheritdoc */
    public function modelClass(): string
    {
        return Topic::class;
    }

    /**
     * Store a newly created topic in data base.
     *
     * @param \App\Dto\StoreTopicDto $data
     *
     * @return \App\Models\Topic
     */
    public function createByAdmin(StoreTopicDto $data): Topic
    {
        $topic = $this->model;
        $topic->name = $data->name;
        $topic->admin()->associate($data->admin);
        $topic->save();

        return $topic;
    }

    /**
     * Display a listing of the topics.
     *
     * @return \Illuminate\Support\Collection
     */
    public function list(): Collection
    {
        $query = $this->with('admin:id,name');
        return $query->get();
    }

    /**
     * Get all messages from a specific topic
     *
     * @param int|\App\Models\Topic $target
     *
     * @return \Illuminate\Support\Collection
     */
    public function subscribers(int|Topic $target): Collection
    {
        $model = $this->resolveTarget($target);

        return $model->users;
    }

    /**
     * User subscriptions to the specific topic
     *
     * @param \App\Models\Topic $topic
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function subscriptionsByTopic(Topic $topic, User $user): void
    {
        $topic->users()->attach($user);
    }

    /**
     * Get list of messages to a specific topic
     *
     * @param int|\App\Models\Topic $target
     *
     * @return \Illuminate\Support\Collection
     */
    public function messages(int|Topic $target): Collection
    {
        $model = $this->resolveTarget($target);

        return $model->messages()->with('messageable')->get();
    }

    /**
     * List all topics that the logged in user is subscribed
     *
     * @return \Illuminate\Support\Collection
     */
    public function listTopicsByLoggedUser(): Collection
    {
        return $this->with('admin')
            ->whereRelation('users', 'users.id', auth()->id())
            ->get();
    }
}
