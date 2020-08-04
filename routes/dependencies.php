<?php

$clientRepository = new \SRC\Infrastructure\Repository\ClientRepository(
    (new \SRC\Infrastructure\Database\Connection())->getConnection()
);

return [
    \SRC\Domain\Client\ClientCreateRepository::class => $clientRepository,
    \SRC\Domain\Client\ClientFindAllRepository::class => $clientRepository,
    \SRC\Domain\Client\ClientFindRepository::class => $clientRepository,
    \SRC\Domain\Client\ClientDeleteRepository::class => $clientRepository,
    \SRC\Domain\Client\ClientUpdateRepository::class => $clientRepository,
    \SRC\Domain\Client\ClientValidator::class => new \SRC\Infrastructure\Validator\ClientValidator()
];