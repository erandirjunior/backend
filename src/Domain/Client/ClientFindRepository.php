<?php

namespace SRC\Domain\Client;

interface ClientFindRepository
{
    public function findById($id): array;
}