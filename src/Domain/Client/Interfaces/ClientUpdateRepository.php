<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientUpdateRepository
{
    public function update(int $id, ClientBoundery $clientBoundery): bool;

    public function checkIfHasOtherClientWithTheSameIdentifier(int $id, string $identifier): bool;
}