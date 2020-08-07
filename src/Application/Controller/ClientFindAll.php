<?php

namespace SRC\Application\Controller;

use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientFindAllHandler;
use SRC\Domain\Client\Interfaces\ClientFindAllRepository;
use SRC\Domain\Client\Interfaces\ContactFindRepository;

class ClientFindAll
{
    public function findAll(ClientFindAllRepository $clientFindAllRepository, ContactFindRepository $contactFindRepository)
    {
        $response = new Response();
        $domain = new ClientFindAllHandler($clientFindAllRepository, $contactFindRepository, $response);
        $domain->findAll();

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}