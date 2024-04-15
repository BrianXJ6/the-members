<?php

namespace App\Http\Controllers;

use App\Http\Resources\{
    ShowTopicResource,
    ShowTopicCollection,
};

use Illuminate\Http\Resources\Json\{
    JsonResource,
    ResourceCollection,
};

use App\Models\Topic;
use App\Services\TopicService;

class TopicController extends Controller
{
    /**
     * Create a new Topic Controller instance
     *
     * @param \App\Services\TopicService $topicService
     */
    public function __construct(private TopicService $topicService)
    {
        //
    }

    /**
     * Display a listing of the topics.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function list(): ResourceCollection
    {
        return ShowTopicCollection::make($this->topicService->list());
    }

    /**
     * Display the specified topic.
     *
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Topic $topic): JsonResource
    {
        return ShowTopicResource::make($topic);
    }
}
