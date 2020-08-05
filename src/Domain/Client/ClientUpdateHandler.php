<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ClientBoundery;
use SRC\Domain\Client\Interfaces\ClientUpdateRepository;
use SRC\Domain\Client\Interfaces\ClientValidator;
use SRC\Domain\Client\Interfaces\ContactCreateRepository;
use SRC\Domain\Client\Interfaces\ContactDeleteRepository;
use SRC\Domain\Client\Interfaces\ContactUpdateRepository;
use SRC\Domain\Client\Interfaces\Response;

class ClientUpdateHandler
{
    private $repository;

    private $boundery;

    private $validator;

    private $response;

    private $contactCeateRepository;

    private $contactUpdateRepository;

    private $contactDeleteRepository;

    public function __construct(
        ClientUpdateRepository $clientUpdateRepository,
        ClientBoundery $clientBoundery,
        ClientValidator $clientValidator,
        Response $response,
        ContactCreateRepository $contactCreateRepository,
        ContactUpdateRepository $contactUpdateRepository,
        ContactDeleteRepository $contactDeleteRepository
    )
    {
        $this->repository               = $clientUpdateRepository;
        $this->boundery                 = $clientBoundery;
        $this->validator                = $clientValidator;
        $this->response                 = $response;
        $this->contactCeateRepository   = $contactCreateRepository;
        $this->contactUpdateRepository  = $contactUpdateRepository;
        $this->contactDeleteRepository  = $contactDeleteRepository;
    }

    public function update(int $id)
    {
        $this->updateIfDataAreValids($id);

        return $this->response;
    }

    private function updateIfDataAreValids($id)
    {
        if ($this->validator->validate($this->boundery)) {
            $this->setResponse($this->validator->errors(), 400);

            return;
        }

        return $this->updateIfUniqueClient($id);
    }

    private function updateIfUniqueClient($id)
    {
        if ($this->repository->checkIfHasOtherClientWithTheSameIdentifier($id, $this->boundery->getIdentifier())) {
            $this->setResponse(['Já existe um cliente com esse CPF/CNPJ!'], 400);

            return;
        }

        return $this->save($id);
    }

    private function save($id)
    {
        $this->setResponse(['Houve um erro ao cadastrar o cliente'], 500);

        if ($this->repository->update($id, $this->boundery)) {
            $this->setResponse([], 204);
            (new ContactUpdateHandler(
                $this->contactUpdateRepository,
                $this->contactCeateRepository,
                $this->contactDeleteRepository
            ))
                ->update($id, $this->boundery->getContacts());
        }
    }

    private function setResponse($msg = [], $code = 200)
    {
        $this->response->setBody(['msg' => $msg]);
        $this->response->setCode($code);
    }
}