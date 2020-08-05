<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ContactCreateRepository;

class ContactCreateHandler
{
    private $repository;

    public function __construct(ContactCreateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($clientId, $contact)
    {
        return $this->repository->create($clientId, $contact);
    }
}