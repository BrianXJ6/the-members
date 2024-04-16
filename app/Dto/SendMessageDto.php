<?php

namespace App\Dto;

use App\Models\{
    User,
    Admin,
};

class SendMessageDto extends BaseDto
{
    /**
     * Create a new Send Message Dto instance
     *
     * @param string $message
     * @param \App\Models\User|\App\Models\Admin $messageable
     */
    public function __construct(
        public readonly string $message,
        public readonly User|Admin $messageable,
    ) {
        //
    }
}
