<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientValidator
{
    public function validate(ClientBoundery $clientBoundery): bool;

    public function errors(): array;
}