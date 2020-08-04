<?php

namespace SRC\Domain\Client\Interfaces;

interface ContactUpdateRepository
{
    public function save(array $data): bool;
}