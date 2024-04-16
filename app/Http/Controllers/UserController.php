<?php

namespace App\Http\Controllers;

use App\Services\{
    TopicService,
};

use App\Http\Resources\ShowTopicCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    /**
     * Create a new User Controller instance
     *
     * @param \App\Services\TopicService $topicService
     * @param \App\Services\MessageService $messageService
     */
    public function __construct(
        private TopicService $topicService,
    ) {
        //
    }

    /**
     * List all topics that the logged in user is subscribed
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function topicList(): ResourceCollection
    {
        return ShowTopicCollection::make(
            $this->topicService->listTopicsByLoggedUser()
        );
    }
}
