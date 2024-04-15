<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    StoreTopicRequest,
    UpdateTopicRequest,
};

use App\Models\Topic;
use App\Services\TopicService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\StoreTopicResource;
use Illuminate\Http\Resources\Json\JsonResource;

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

    /**
     * Update the specified topic in storage.
     *
     * @param \App\Http\Requests\UpdateTopicRequest $request
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTopicRequest $request, Topic $topic): JsonResponse
    {
        $this->topicService->update($request->data()->toArray(), $topic);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified topic from storage.
     *
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Topic $topic): JsonResponse
    {
        $this->topicService->delete($topic);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
