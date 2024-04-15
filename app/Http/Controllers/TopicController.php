<?php

namespace App\Http\Controllers;

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
     * Store a newly created topic in storage.
     *
     * @param \App\Http\Requests\StoreTopicRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreTopicRequest $request): JsonResource
    {
        return StoreTopicResource::make(
            $this->topicService->createByAdmin($request->data())
        );
    }
}
