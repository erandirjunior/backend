<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ContactDeleteRepository;

class ContactDeleteHandler
{
    private $repository;

    public function __construct(ContactDeleteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function delete(int $clientId, string $ids)
    {
        $this->repository->delete($clientId, $ids);
    }
}