<?php

namespace App\Services;

use App\Repositories\ClientRepository;

class ClientService extends Service
{
    public function __construct(ClientRepository $repository)
    {
        parent::__construct($repository);
    }
}
