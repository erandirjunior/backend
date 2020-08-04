<?php

namespace SRC\Infrastructure\Repository;

use SRC\Domain\Client\Interfaces\ContactCreateRepository;

class ContactRepository implements ContactCreateRepository
{
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function create($clientId, $data): bool
    {
        $stmt = $this->connection->prepare("INSERT INTO contact (client_id, type, contact) VALUE (?, ?, ?)");
        $stmt->bindValue(1, $clientId);
        $stmt->bindValue(2, $data['type']);
        $stmt->bindValue(3, $data['contact']);

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