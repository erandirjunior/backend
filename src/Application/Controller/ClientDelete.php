<?php

namespace SRC\Application\Controller;

use PlugRoute\Http\Request;
use SRC\Application\Presenter\JsonPresenter;
use SRC\Application\Response\Response;
use SRC\Domain\Client\ClientDeleteHandler;
use SRC\Domain\Client\Interfaces\ClientDeleteRepository;

class ClientDelete
{
    public function delete(ClientDeleteRepository $clientDeleteRepository, Request $request)
    {
        $response = new Response();
        $domain = new ClientDeleteHandler($clientDeleteRepository, $response);
        $domain->delete($request->parameter('id'));

        echo (new JsonPresenter())->json($response->getBody(), $response->getCode());
    }
}