<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class BaseRepository
{
    use ForwardsCalls;

    /**
     * Protected attributes.
     *
     * @var null|\Illuminate\Database\Eloquent\Model
     */
    protected ?Model $model;

    /**
     * Create a new Base Repository instance.
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * Resolve the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function resolveModel(): Model
    {
        $model = app($this->modelClass());

        if (!$model instanceof Model)
            throw new Exception("Class {$this->modelClass()} is not a valid model");

        return $model;
    }

    /**
     * Resolve the target
     *
     * @param int|\Illuminate\Database\Eloquent\Model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function resolveTarget(int|Model $target): Model
    {
        return !$target instanceof Model ? $this->newInstance()->findOrFail($target) : $target;
    }

    /**
     * Save the model to the database.
     *
     * @param array $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $attributes): Model
    {
        $model = $this->newInstance()->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * Update a model in repository by id.
     *
     * @param array $attributes
     * @param int|\Illuminate\Database\Eloquent\Model $target
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $attributes, int|Model $target): Model
    {
        $model = $this->resolveTarget($target);
        $model->fill($attributes)->save();

        return $model;
    }

    /**
     * Delete the model from the database.
     *
     * @param int|\Illuminate\Database\Eloquent\Model $target
     *
     * @return bool
     */
    public function delete(int|Model $target): bool
    {
        $model = $this->resolveTarget($target);

        return $model->delete();
    }

    /**
     * Class that will belong to this repository stream.
     *
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments): mixed
    {
        return $this->forwardCallTo($this->model, $method, $arguments);
    }
}
