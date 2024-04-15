<?php

namespace App\Repositories;

use App\Models\Topic;
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
}
