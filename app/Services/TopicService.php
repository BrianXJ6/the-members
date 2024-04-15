<?php

namespace App\Services;

use App\Repositories\TopicRepository;

class TopicService extends BaseService
{
    /**
     * Create a new User Service instance
     *
     * @param \App\Repositories\TopicRepository $topicRepository
     */
    public function __construct(private TopicRepository $topicRepository)
    {
        parent::__construct($topicRepository);
    }
}
