<?php

namespace SRC\Domain\Client;

interface ClientValidator
{
    public function validate(ClientBoundery $clientBoundery): bool;

    public function errors(): array;
}