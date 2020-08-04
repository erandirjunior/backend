<?php

namespace SRC\Application\Controller;

use PlugRoute\Http\Request;
use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientFindHandler;
use SRC\Domain\Client\ClientFindRepository;

class ClientFind
{
    public function findById(ClientFindRepository $clientFindRepository, Request $request)
    {
        $response = new Response();
        $domain = new ClientFindHandler($clientFindRepository, $response);
        $domain->findById($request->parameter('id'));

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}