<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientFindAllRepository
{
    public function findAll(): array;
}