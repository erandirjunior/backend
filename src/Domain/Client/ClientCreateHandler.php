<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ClientBoundery;
use SRC\Domain\Client\Interfaces\ClientCreateRepository;
use SRC\Domain\Client\Interfaces\ClientValidator;
use SRC\Domain\Client\Interfaces\ContactCreateRepository;
use SRC\Domain\Client\Interfaces\Response;

class ClientCreateHandler
{
    private $boundery;

    private $repository;

    private $validator;

    private $response;

    private $contactRepository;

    public function __construct(
        ClientBoundery $clientBoundery,
        ClientCreateRepository $clientCreateRepository,
        ClientValidator $clientValidator,
        Response $response,
        ContactCreateRepository $contactCreateRepository
    )
    {
        $this->boundery = $clientBoundery;
        $this->repository = $clientCreateRepository;
        $this->validator = $clientValidator;
        $this->response = $response;
        $this->contactRepository = $contactCreateRepository;
    }

    public function create()
    {
        $this->createIfDataAreValids();

        return $this->response;
    }

    private function createIfDataAreValids()
    {
        if ($this->validator->validate($this->boundery)) {
            $this->setResponse($this->validator->errors(), 400);

            return;
        }

        return $this->createIfUniqueClient();
    }

    private function createIfUniqueClient()
    {
        if ($this->repository->findByClientIdentifier($this->boundery->getIdentifier())) {
            $this->setResponse(['Cliente já está cadastrado!'], 400);

            return;
        }

        return $this->save();
    }

    private function save()
    {
        $id = $this->repository->create($this->boundery);

        $this->setResponse(['Houve um erro ao cadastrar o cliente'], 500);

        if ($id) {
            $this->setResponse([], 201);
            (new ContactCreateHandler($this->contactRepository))
                ->create($id, $this->boundery->getContacts());
        }
    }

    private function setResponse($msg = [], $code = 200)
    {
        $this->response->setBody(['msg' => $msg]);
        $this->response->setCode($code);
    }
}