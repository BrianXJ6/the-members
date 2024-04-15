<?php

namespace App\Dto;

abstract class BaseDto
{
    /**
     * Serialize instance
     *
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this;
    }
}
