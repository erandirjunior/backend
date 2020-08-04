<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ClientFindRepository;
use SRC\Domain\Client\Interfaces\Response;

class ClientFindHandler
{
    private $repository;

    private $response;

    /**
     * ClientFindAllHandler constructor.
     * @param $repository
     */
    public function __construct(ClientFindRepository $repository, Response $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function findById($id)
    {
        $data = $this->repository->findById($id);

        $this->response->setCode(200);
        $this->response->setBody($data);
    }
}