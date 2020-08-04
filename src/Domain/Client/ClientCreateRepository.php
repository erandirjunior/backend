<?php

namespace SRC\Domain\Client;

interface ClientCreateRepository
{
    public function create(ClientBoundery $clientBoundery): bool;

    public function findByClientIdentifier(string $identifier): bool;
}