<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Resources\AdminCreateUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminController extends Controller
{
    /**
     * Create a new Admin Controller instance
     *
     * @param \App\Services\UserService $userService
     */
    public function __construct(private UserService $userService)
    {
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
}
