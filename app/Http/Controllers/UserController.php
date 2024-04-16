<?php

namespace App\Http\Controllers;

use App\Services\{
    TopicService,
    MessageService,
};

use App\Http\Resources\{
    SendMessageResource,
    ShowTopicCollection,
};

use Illuminate\Http\Resources\Json\{
    JsonResource,
    ResourceCollection,
};

use App\Models\Topic;
use App\Http\Requests\UserSendMessageRequest;

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
        private MessageService $messageService,
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

    /**
     * List messages from a subscribed topic with logged in Users
     *
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function messageList(Topic $topic): ResourceCollection
    {
        return SendMessageResource::collection(
            $this->messageService->listMessagesFromTopicByLoggedUser($topic)
        );
    }

    /**
     * Send message with user logged in to a specific topic
     *
     * @param \App\Http\Requests\UserSendMessageRequest $request
     * @param Topic $topic
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function sendMessage(UserSendMessageRequest $request, Topic $topic): JsonResource
    {
        return SendMessageResource::make(
            $this->messageService->sendMessage($request->data(), $topic)
        );
    }
}
