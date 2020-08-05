<?php

namespace SRC\Domain\Client\Interfaces;

interface ContactDeleteRepository
{
    public function delete(int $clientId, string $ids): bool;
}