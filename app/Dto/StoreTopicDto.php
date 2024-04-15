<?php

namespace App\Dto;

use App\Models\Admin;

class StoreTopicDto extends BaseDto
{
    /**
     * Create a new Admin Create User Dto instance
     *
     * @param string $name
     * @param \App\Models\Admin $admin
     */
    public function __construct(
        public readonly string $name,
        public readonly Admin $admin,
    ) {
        //
    }
}
