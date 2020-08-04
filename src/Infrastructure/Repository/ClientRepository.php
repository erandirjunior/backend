<?php

namespace SRC\Infrastructure\Repository;

use SRC\Domain\Client\ClientDeleteRepository;
use SRC\Domain\Client\ClientFindAllRepository;
use SRC\Domain\Client\ClientFindRepository;

class ClientRepository implements
    \SRC\Domain\Client\ClientCreateRepository,
    ClientFindAllRepository,
    ClientFindRepository,
    ClientDeleteRepository
{
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function create(\SRC\Domain\Client\ClientBoundery $clientBoundery): bool
    {
        $stmt = $this->connection->prepare("INSERT INTO client (name, type, identifier) VALUE (?, ?, ?)");
        $stmt->bindValue(1, $clientBoundery->getName());
        $stmt->bindValue(2, $clientBoundery->getTypePerson());
        $stmt->bindValue(3, $clientBoundery->getIdentifier());

        return $stmt->execute() ? $this->connection->lastInsertId() : 0;
    }

    public function findByClientIdentifier(string $identifier): bool
    {
        $stmt = $this->connection->prepare("SELECT id FROM client WHERE identifier = ? AND deleted_at IS NULL");
        $stmt->bindValue(1, $identifier);
        $stmt->execute();
        return !!$stmt->fetch();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT name, id, name, type, identifier FROM client WHERE deleted_at IS NULL");


        return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    public function findById($id): array
    {
        $stmt = $this->connection->prepare("SELECT
                                                name,
                                                id,
                                                name,
                                                type,
                                                identifier
                                            FROM
                                                client
                                            WHERE
                                                deleted_at IS NULL AND
                                                id = ?");
        $stmt->bindValue(1, $id);

        return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    public function delete($id): bool
    {
        $stmt = $this->connection->prepare("UPDATE client SET deleted_at = NOW() WHERE id = ?");
        $stmt->bindValue(1, $id);

        return $stmt->execute() ? true : false;
    }
}