<?php

namespace SRC\Domain\Client\Interfaces;

interface ContactUpdateRepository
{
    public function update($clientId, array $data): bool;
}