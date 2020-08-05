<?php

namespace SRC\Domain\Client\Interfaces;

interface ContactCreateRepository
{
    public function create(int $clientId, array $data): int;
}