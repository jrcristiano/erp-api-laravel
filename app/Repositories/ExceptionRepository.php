<?php

namespace App\Repositories;

use App\Models\Exception;

class ExceptionRepository extends Repository
{
    public function __construct(Exception $model)
    {
        parent::__construct($model);
    }
}
