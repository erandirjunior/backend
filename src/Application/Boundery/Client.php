<?php

namespace SRC\Application\Boundery;

class Client implements \SRC\Domain\Client\Interfaces\ClientBoundery
{
    private $name;
    private $typePerson;
    private $identifier;
    private $contacts;

    /**
     * Client constructor.
     * @param $name
     * @param $typePerson
     * @param $identifier
     * @param $contacts
     */
    public function __construct($name = '', $typePerson = '', $identifier = '', $contacts = [])
    {
        $this->name = $name;
        $this->typePerson = $typePerson;
        $this->identifier = $identifier;
        $this->contacts = $contacts;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTypePerson(): int
    {
        return $this->typePerson;
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }
}