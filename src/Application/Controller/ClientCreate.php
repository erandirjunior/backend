<?php

namespace SRC\Application\Controller;

use PlugRoute\Http\Request;
use SRC\Application\Boundery\Client;
use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientCreateHandler;
use SRC\Domain\Client\Interfaces\ClientCreateRepository;
use SRC\Domain\Client\Interfaces\ClientValidator;
use SRC\Domain\Client\Interfaces\ContactCreateRepository;

class ClientCreate
{
    private $request;

    private $validator;

    private $repository;

    private $contactRepository;

    public function __construct(
        Request $request,
        ClientValidator $clientValidator,
        ClientCreateRepository $clientCreateRepository,
        ContactCreateRepository $contactCreateRepository
    )
    {
        $this->request = $request;
        $this->validator = $clientValidator;
        $this->repository = $clientCreateRepository;
        $this->contactRepository = $contactCreateRepository;
    }

    public function create()
    {
        $name       = $this->request->input('name');
        $typePerson = $this->request->input('typePerson');
        $identifier = $this->request->input('identifier');
        $contacts   = $this->request->input('contacts');

        $client     = new Client($name, $typePerson, $identifier, $contacts);
        $response   = new Response();

        $domain = new ClientCreateHandler(
            $client,
            $this->repository,
            $this->validator,
            $response,
            $this->contactRepository
        );

        $domain->create();

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}