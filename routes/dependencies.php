<?php

$clientRepository = new \SRC\Infrastructure\Repository\ClientRepository(
    (new \SRC\Infrastructure\Database\Connection())->getConnection()
);

$contactRepository = new \SRC\Infrastructure\Repository\ContactRepository(
    (new \SRC\Infrastructure\Database\Connection())->getConnection()
);

return [
    \SRC\Domain\Client\Interfaces\ClientCreateRepository::class => $clientRepository,
    \SRC\Domain\Client\Interfaces\ClientFindAllRepository::class => $clientRepository,
    \SRC\Domain\Client\Interfaces\ClientFindRepository::class => $clientRepository,
    \SRC\Domain\Client\Interfaces\ClientDeleteRepository::class => $clientRepository,
    \SRC\Domain\Client\Interfaces\ClientUpdateRepository::class => $clientRepository,
    \SRC\Domain\Client\Interfaces\ContactCreateRepository::class => $contactRepository,
    \SRC\Domain\Client\Interfaces\ClientValidator::class => new \SRC\Infrastructure\Validator\ClientValidator()
];