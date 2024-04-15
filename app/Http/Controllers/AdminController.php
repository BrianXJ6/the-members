<?php

namespace App\Http\Controllers;

use App\Models\{
    User,
    Topic,
};

use App\Services\{
    UserService,
    TopicService,
};

use App\Http\Requests\{
    AdminCreateUserRequest,
    AdminStoreTopicRequest,
    AdminUpdateTopicRequest,
};

use App\Http\Resources\{
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
     */
    public function __construct(
        private UserService $userService,
        private TopicService $topicService,
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
}
