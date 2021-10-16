<?php

namespace App\Services;

use App\Repositories\Repository;
use Exception;
use Illuminate\Http\Request;

abstract class Service
{
    public function __construct(protected Repository $repository) {}
    
    public function paginate(int $perPage = 25)
    {
        return $this->repository->paginate($perPage);
    }

    public function fetchAll(Request $request, array $relations = [])
    {
        try {
            $filters = $this->filters($request);
            return $this->repository->fetchAll($filters, $relations);

        } catch (Exception $exception) {
            throw new Exception('Erro ao buscar lista de dados: parâmetros inválidos.');
        }
    }

    public function first(array $relations = [])
    {
        return $this->repository->first($relations);
    }

    public function findOrFail(int $id, array $relations = [])
    {
        try {
            return $this->repository->findOrFail($id, $relations);

        } catch (Exception $exception) {
            throw new Exception("Não há resultados correspondentes para o id {$id}.");
        }
    }

    public function find(int $id, array $relations = [])
    {
        try {
            return $this->repository->find($id, $relations);

        } catch (Exception $exception) {
            throw new Exception("Não há resultados correspondentes para o id {$id}.");
        }
    }

    public function save(array $data)
    {
        $data['id'] = $data['id'] ?? null;
        try {
            if (!$data['id']) {
                return $this->create($data);    
            }

            $this->update($data);
            return $data['id'];

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create($data);

        } catch (Exception $exception) {
            throw new Exception('Erro ao realizar cadastro.');
        }
    }

    public function update(array $data)
    {
        try {
            return $this->repository->update($data);

        } catch (Exception $exception) {
            throw new Exception('Erro ao realizar cadastro.');
        }
    }

    public function updateOrCreate(array $data)
    {
        return $this->repository->updateOrCreate($data);
    }

    public function firstOrCreate(array $data)
    {
        return $this->repository->firstOrCreate($data);
    }

    public function delete(int $id)
    {
        try {
            $this->repository->delete($id);
            
        } catch(Exception $exception) {
            throw new Exception("Erro ao remover: não há resultados correspondentes para o id {$id}.");
        }
    }

    public function forceDelete(int $id)
    {
        return $this->repository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->repository->restore($id);
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }

    protected function filters(Request $request): array
    {
        $filter['columns'] = $request->get('columns') ?? '*';
        $filter['orderBy'] = $request->get('orderBy') ?? 'asc';
        $filter['sortBy'] = $request->get('sortBy') ?? 'id';
        $filter['paginated'] = $request->get('paginated') == 'true' ? true : false;
        $filter['perPage'] = $request->get('perPage') ?? 25;
        $filter['limit'] = $request->get('limit') ?? 25;
        $filter['offset'] = $request->get('offset') ?? null;
        return $filter;
    }

    protected function saveException(array $data)
    {
        extract($data);

        $exceptionService = resolve(ExceptionService::class);
        return $exceptionService->save([
            'exception' => $exception
        ]);
    }

    protected function throwsException(Exception $exception)
    {                
        $this->saveException([
            'exception' => $exception
        ]);

        throw $exception;
    }
}