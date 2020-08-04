<?php

namespace SRC\Domain\Client\Interfaces;

interface ClientBoundery
{
    public function getName(): string;
    public function getTypePerson(): int;
    public function getIdentifier(): int;
    public function getContacts(): array;
}