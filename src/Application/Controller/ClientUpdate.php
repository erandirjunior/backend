<?php


namespace SRC\Application\Controller;


use PlugRoute\Http\Request;
use SRC\Application\Boundery\Client;
use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientUpdateHandler;
use SRC\Domain\Client\Interfaces\ClientUpdateRepository;
use SRC\Domain\Client\Interfaces\ClientValidator;
use SRC\Domain\Client\Interfaces\ContactCreateRepository;
use SRC\Domain\Client\Interfaces\ContactDeleteRepository;
use SRC\Domain\Client\Interfaces\ContactUpdateRepository;

class ClientUpdate
{
    private $request;

    private $repository;

    private $validator;

    private $contactCeateRepository;

    private $contactUpdateRepository;

    private $contactDeleteRepository;


    public function __construct(
        Request $request,
        ClientUpdateRepository $clientUpdateRepository,
        ClientValidator $clientValidator,
        ContactCreateRepository $contactCreateRepository,
        ContactUpdateRepository $contactUpdateRepository,
        ContactDeleteRepository $contactDeleteRepository)
    {
        $this->request                  = $request;
        $this->repository               = $clientUpdateRepository;
        $this->validator                = $clientValidator;
        $this->contactCeateRepository   = $contactCreateRepository;
        $this->contactUpdateRepository  = $contactUpdateRepository;
        $this->contactDeleteRepository  = $contactDeleteRepository;
    }

    public function update()
    {
        $id         = $this->request->parameter('id');
        $name       = $this->request->input('name');
        $typePerson = $this->request->input('typePerson');
        $identifier = $this->request->input('identifier');
        $contacts   = $this->request->input('contacts');

        $client     = new Client($name, $typePerson, $identifier, $contacts);
        $response   = new Response();

        $domain = new ClientUpdateHandler(
            $this->repository,
            $client,
            $this->validator,
            $response,
            $this->contactCeateRepository,
            $this->contactUpdateRepository,
            $this->contactDeleteRepository
        );

        $domain->update($id);

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}