<?php

namespace App\Services;

use App\Repositories\ExceptionRepository;
use Exception;

class ExceptionService extends Service
{
    public function __construct(ExceptionRepository $repository)
    {
        parent::__construct($repository);
    }

    public function createException(Exception $exception)
    {
        $data = [];
        $data['message'] = $exception->getMessage();
        $data['line'] = $exception->getLine();
        $data['trace'] = json_encode($exception->getTrace());
        $data['code'] = $exception->getCode();
        $data['exception'] = json_encode($exception);

        return $this->repository->create($data);
    }
}
