<?php

namespace App\Dto;

class AdminCreateUserDto extends BaseDto
{
    /**
     * Create a new Admin Create User Dto instance
     *
     * @param string $name
     * @param string $email
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {
        //
    }
}
