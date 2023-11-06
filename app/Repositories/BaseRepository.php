<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(private readonly Model $model)
    {
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(string $field, string $value): Model
    {
        return $this->model->where($field, $value)->firstOrFail();
    }

    public function all(): array
    {
        return $this->model->all()->toArray();
    }
}
