<?php

namespace SRC\Domain\Client;

use SRC\Application\Response\Response;
use SRC\Domain\Client\Interfaces\ClientFindAllRepository;
use SRC\Domain\Client\Interfaces\ContactFindRepository;

class ClientFindAllHandler
{
    private $repository;

    private $response;

    private $contactRepository;

    /**
     * ClientFindAllHandler constructor.
     * @param $repository
     */
    public function __construct(ClientFindAllRepository $repository, ContactFindRepository $contactFindRepository, Response $response)
    {
        $this->repository = $repository;
        $this->contactRepository = $contactFindRepository;
        $this->response = $response;
    }

    public function findAll()
    {
        $data = $this->repository->findAll();


        foreach ($data as $key => $client) {
            $data[$key]['contacts'] = $this->contactRepository->findByClientId($client['id']);
        }

        $this->response->setCode(200);
        $this->response->setBody($data);
    }
}