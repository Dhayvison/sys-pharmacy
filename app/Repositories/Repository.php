<?php

namespace App\Repositories;

use App\Models\DTO\Interfaces\DTO;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(DTO $dto): Model
    {
        return $this->model->create($dto->toArray());
    }

    public function update($id, DTO $dto): ?Model
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->update($dto->toArray());
            return $model;
        }
        return null;
    }

    public function delete($id)
    {
        $model = $this->model->find($id);
        if ($model) {
            $model->delete();
            return true;
        }
        return false;
    }
}
