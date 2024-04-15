<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class BaseService
{
    use ForwardsCalls;

    /**
     * Create a new Base Action instance
     *
     * @param \App\Repositories\BaseRepository $repository
     */
    public function __construct(private BaseRepository $repository)
    {
        //
    }

    /**
     * Handle dynamic method calls into the repository.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments): mixed
    {
        return $this->forwardCallTo($this->repository, $method, $arguments);
    }
}
