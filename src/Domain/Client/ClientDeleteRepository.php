<?php

namespace SRC\Domain\Client;

interface ClientDeleteRepository
{
    public function delete($id): bool;
}