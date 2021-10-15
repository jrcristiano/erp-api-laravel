<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $filter = [];
    
    public function __construct(protected Model $model) {}

    public function paginate(int $perPage)
    {
        return $this->model->paginate($perPage);
    }

    public function fetchAll(array $filter, array $with = [])
    {
        extract($filter);

        $query = $this->model->when($sortBy, 
            function ($query) use ($sortBy, $orderBy) {
                if (strpos($sortBy, ',') == 0) {
                    return $query->orderBy($sortBy, $orderBy);
                }

                $sortBy = explode(',', $sortBy);
                foreach ($sortBy as $column) {
                    $query->orderBy($column, $orderBy);
                }
        })
        ->when($offset && (isset($paginate) == false || $paginate == false),
            function ($query) use ($offset, $limit) {
                $query->skip($offset)->take($limit);
        })
        ->when($with != [], function ($query) use ($with) {
            foreach ($with as $model) {
                $query->with($model);
            }
        });

        return $filter['paginated'] ? $query->paginate($filter['perPage']) : $query->get();
    }

    public function first(array $with = [])
    {
        return $this->model->when($with != [], 
            function ($query) use ($with) {
                foreach ($with as $model) {
                    $query->with($model);
                }
        })
        ->first();
    }

    public function findOrFail(int $id, array $with = [], $trashed = false)
    {
        $query = $this->model
            ->when($with != [], function ($query) use ($with) {
                foreach ($with as $model) {
                    $query->with($model);
                }
        });

        if ($trashed) {
            return $query->withTrashed()
                ->findOrFail($id);
        }

        return $query->findOrFail($id);
    }

    public function find(int $id, array $with = [], $trashed = false)
    {
        $query = $this->model
            ->when($with != [], function ($query) use ($with) {
                foreach ($with as $model) {
                    $query->with($model);
                }
        });

        if ($trashed) {
            return $query->with($with)
                ->withTrashed()
                ->find($id);
        }

        return $query->with($with)
            ->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data)
    {
        $data['id'] = $data['id'] ?? null;
        return $this->model->find($data['id'])
            ->update($data);
    }

    public function updateOrCreate(array $data)
    {
        return $this->model->updateOrCreate($data);
    }

    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function delete(int $id)
    {
        return $this->model->findOrFail($id)
            ->delete();
    }

    public function forceDelete(int $id)
    {
        return $this->model->findOrFail($id)
            ->forceDelete();
    }

    public function restore(int $id)
    {
        return $this->model->findOrFail($id)
            ->restore();
    }

    public function getModel()
    {
        return $this->model;
    }
}
