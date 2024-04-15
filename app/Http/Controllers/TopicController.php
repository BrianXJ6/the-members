<?php

namespace App\Http\Controllers;

use App\Services\{
    UserService,
    TopicService,
};

use App\Http\Resources\{
    ShowTopicResource,
    ShowTopicCollection,
    SubscribersTopicResouce,
};

use Illuminate\Http\Resources\Json\{
    JsonResource,
    ResourceCollection,
};

use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SubscriptionsTopicRequest;

class TopicController extends Controller
{
    /**
     * Create a new Topic Controller instance
     *
     * @param \App\Services\TopicService $topicService
     * @param \App\Services\UserService $userService
     */
    public function __construct(
        private TopicService $topicService,
        private UserService $userService,
    ) {
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

    /**
     * Get all messages from a specific topic
     *
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function subscribers(Topic $topic): ResourceCollection
    {
        return SubscribersTopicResouce::collection($this->topicService->subscribers($topic));
    }

    /**
     * User subscriptions to the specific topic
     *
     * @param \App\Http\Requests\SubscriptionsTopicRequest $request
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscriptions(SubscriptionsTopicRequest $request, Topic $topic): JsonResponse
    {
        $user = $this->userService->subscriptionsByTopic($request->data());
        $this->topicService->subscriptionsByTopic($topic, $user);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
