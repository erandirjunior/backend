<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientFindRepository
{
    public function findById($id): array;
}