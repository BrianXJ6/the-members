<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Topic,
};

use App\Services\{
    UserService,
    TopicService,
    MessageService,
};

use App\Http\Requests\{
    AdminCreateUserRequest,
    AdminStoreTopicRequest,
    AdminUpdateTopicRequest,
    AdminSendMessageRequest,
};

use App\Http\Resources\{
    SendMessageResource,
    AdminCreateUserResource,
    AdminStoreTopicResource,
};

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminController extends Controller
{
    /**
     * Create a new Admin Controller instance
     *
     * @param \App\Services\UserService $userService
     * @param \App\Services\TopicService $topicService
     * @param \App\Services\MessageService $messageService
     */
    public function __construct(
        private UserService $userService,
        private TopicService $topicService,
        private MessageService $messageService,
    ) {
        //
    }

    /**
     * Create a new user
     *
     * @param \App\Http\Requests\AdminCreateUserRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function createUser(AdminCreateUserRequest $request): JsonResource
    {
        return AdminCreateUserResource::make(
            $this->userService->create($request->data()->toArray())
        );
    }

    /**
     * Store a newly created topic by admin in storage.
     *
     * @param \App\Http\Requests\AdminStoreTopicRequest $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function storeTopic(AdminStoreTopicRequest $request): JsonResource
    {
        return AdminStoreTopicResource::make(
            $this->topicService->createByAdmin($request->data())
        );
    }

    /**
     * Update the specified topic in storage.
     *
     * @param \App\Http\Requests\AdminUpdateTopicRequest $request
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTopic(AdminUpdateTopicRequest $request, Topic $topic): JsonResponse
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
    public function deleteTopic(Topic $topic): JsonResponse
    {
        $this->topicService->delete($topic);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Subscribe user to the specific topic
     *
     * @param \App\Models\Topic $topic
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Topic $topic, User $user): JsonResponse
    {
        $this->userService->subscriptionsByAdmin($topic, $user);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Unsubscribe user associated with specific topic
     *
     * @param \App\Models\Topic $topic
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe(Topic $topic, User $user): JsonResponse
    {
        $this->userService->unsubscribeByAdmin($topic, $user);

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Post a message to a specific topic
     *
     * @param \App\Http\Requests\AdminSendMessageRequest $request
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function sendMessage(AdminSendMessageRequest $request, Topic $topic): JsonResource
    {
        return SendMessageResource::make(
            $this->messageService->sendMessage($request->data(), $topic)
        );
    }
}
