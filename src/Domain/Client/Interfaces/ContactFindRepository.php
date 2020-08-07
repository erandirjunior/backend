<?php

namespace SRC\Domain\Client\Interfaces;

interface ContactFindRepository
{
    public function findByClientId($clientId): array;
}