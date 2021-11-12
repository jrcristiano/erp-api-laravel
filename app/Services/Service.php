<?php

namespace App\Services;

use App\Repositories\Repository;
use Exception;

abstract class Service
{
    public function __construct(protected Repository $repository) {}

    public function fetchAll(array $filter = [], array $relations = [])
    {
        try {
            $filters = $this->filters($filter);
            return $this->repository->fetchAll($filters, $relations);

        } catch (Exception $exception) {
            throw new Exception("Erro ao buscar dados na tabela {$this->repository->getTableName()}: parâmetros inválidos.");
        }
    }

    public function first(array $relations = [])
    {
        
        try {
            return $this->repository->first($relations);

        } catch (Exception $exception) {
            $relations = implode(', ', $relations);
            throw new Exception("Erro ao buscar dados relacionados a(s) tabela(s) {$relations}.");
        }
    }

    public function findOrFail(int $id, array $relations = [])
    {
        try {
            return $this->repository->findOrFail($id, $relations);

        } catch (Exception $exception) {
            throw new Exception("Não há resultados correspondentes para id {$id}.");
        }
    }

    public function find(int $id, array $relations = [])
    {
        try {
            return $this->repository->find($id, $relations);

        } catch (Exception $exception) {
            throw new Exception("Não há resultados correspondentes para id {$id}.");
        }
    }

    public function save(array $data)
    {
        $data['id'] = $data['id'] ?? null;

        if (!$data['id']) {
            return $this->create($data);    
        }

        return $this->update($data);
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create($data);

        } catch (Exception $exception) {
            throw new Exception("Erro ao cadastrar dados na tabela {$this->repository->getTableName()}.");
        }
    }

    public function update(array $data)
    {
        try {
            return $this->repository->update($data);

        } catch (Exception $exception) {
            throw new Exception("Erro ao atualizar dados na tabela {$this->repository->getTableName()}.");
        }
    }

    public function updateOrCreate(array $data)
    {
        try {
            return $this->repository->updateOrCreate($data);

        } catch (Exception $exception) {
            throw new Exception("Erro ao atualizar ou criar dado na tabela{$this->repository->getTableName()}.");
        }
    }

    public function firstOrCreate(array $data)
    {
        try {
            return $this->repository->firstOrCreate($data);

        } catch (Exception $exception) {
            throw new Exception("Erro ao cadastrar ou retornar primeiro recurso na tabela {$this->repository->getTableName()}.");
        }
    }

    public function delete(int $id)
    {
        try {
            $this->repository->delete($id);
            
        } catch(Exception $exception) {
            throw new Exception("Erro ao remover: sem resultados correspondentes para id {$id}.");
        }
    }

    public function forceDelete(int $id)
    {
        try {
            return $this->repository->forceDelete($id);

        } catch (Exception $exception) {
            throw new Exception("Erro ao forçar remoção: sem resultados correspondentes para id {$id}.");
        }
    }

    public function restore(int $id)
    {
        try {
            return $this->repository->restore($id);

        } catch (Exception $exception) {
            throw new Exception("Erro ao restaurar o recurso: sem resultados correspondentes para id {$id}.");
        }
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }

    protected function filters(array $filter): array
    {
        $filter['columns'] = isset($filter['columns']) ? explode(',', $filter['columns']) : '*';
        $filter['orderBy'] = $filter['orderBy'] ?? 'desc';
        $filter['sortBy'] = $filter['sortBy'] ?? 'id';
        $filter['paginated'] = isset($filter['paginated']) && $filter['paginated'] == 'true' ? true : false;
        $filter['perPage'] = $filter['perPage'] ?? 25;
        $filter['limit'] = $filter['limit'] ?? 25;
        $filter['offset'] = $filter['offset'] ?? 0;
        return $filter;
    }
}