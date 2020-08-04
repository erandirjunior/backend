<?php

namespace SRC\Domain\Client;

interface ClientFindAllRepository
{
    public function findAll(): array;
}