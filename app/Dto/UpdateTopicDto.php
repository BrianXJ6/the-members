<?php

namespace App\Dto;

class UpdateTopicDto extends BaseDto
{
    /**
     * Create a new Admin Create User Dto instance
     *
     * @param string $name
     */
    public function __construct(public readonly string $name)
    {
        //
    }
}
