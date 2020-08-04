<?php

namespace SRC\Domain\Client;

use SRC\Application\Response\Response;
use SRC\Domain\Client\Interfaces\ClientFindAllRepository;

class ClientFindAllHandler
{
    private $repository;

    private $response;

    /**
     * ClientFindAllHandler constructor.
     * @param $repository
     */
    public function __construct(ClientFindAllRepository $repository, Response $response)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    public function findAll()
    {
        $data = $this->repository->findAll();

        $this->response->setCode(200);
        $this->response->setBody($data);
    }
}