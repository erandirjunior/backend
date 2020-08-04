<?php

namespace SRC\Application\Controller;

use PlugRoute\Http\Request;
use SRC\Application\Boundery\Client;
use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientCreateHandler;
use SRC\Domain\Client\ClientCreateRepository;
use SRC\Domain\Client\ClientValidator;

class ClientCreate
{
    private $request;

    private $validator;

    private $repository;

    public function __construct(
        Request $request,
        ClientValidator $clientValidator,
        ClientCreateRepository $clientCreateRepository
    )
    {
        $this->request = $request;
        $this->validator = $clientValidator;
        $this->repository = $clientCreateRepository;
    }

    public function create()
    {
        $name       = $this->request->input('name');
        $typePerson = $this->request->input('typePerson');
        $identifier = $this->request->input('identifier');
        $contacts   = $this->request->input('contacts');

        $client     = new Client($name, $typePerson, $identifier, $contacts);
        $response   = new Response();

        $domain = new ClientCreateHandler($client, $this->repository, $this->validator, $response);
        $domain->create();

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}