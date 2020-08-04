<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientDeleteRepository
{
    public function delete($id): bool;
}