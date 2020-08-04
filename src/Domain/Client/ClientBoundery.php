<?php

namespace SRC\Domain\Client;

interface ClientBoundery
{
    public function getName(): string;
    public function getTypePerson(): int;
    public function getIdentifier(): int;
    public function getContacts(): array;
}