<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientCreateRepository
{
    public function create(ClientBoundery $clientBoundery): int;

    public function findByClientIdentifier(string $identifier): bool;
}