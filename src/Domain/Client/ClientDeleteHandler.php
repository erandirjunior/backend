<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ClientDeleteRepository;
use SRC\Domain\Client\Interfaces\Response;

class ClientDeleteHandler
{
    private $repository;

    private $response;

    public function __construct(ClientDeleteRepository $clientDeleteRepository, Response $response)
    {
        $this->repository = $clientDeleteRepository;
        $this->response = $response;
    }

    public function delete($id)
    {
        $this->response->setBody([]);
        $this->response->setCode(204);

        if (!$this->repository->delete($id)) {
            $this->response->setBody(['Houve um erro ao excluir o cliente!']);
            $this->response->setCode(500);
        }
    }
}