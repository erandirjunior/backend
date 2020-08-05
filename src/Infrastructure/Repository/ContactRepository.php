<?php

namespace SRC\Infrastructure\Repository;

use SRC\Domain\Client\Interfaces\ContactCreateRepository;
use SRC\Domain\Client\Interfaces\ContactDeleteRepository;
use SRC\Domain\Client\Interfaces\ContactUpdateRepository;

class ContactRepository implements ContactCreateRepository, ContactUpdateRepository, ContactDeleteRepository
{
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function create($clientId, $data): int
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

    public function delete(int $clientId, string $ids): bool
    {
        $stmt = $this->connection->prepare("UPDATE
                                                contact
                                            SET
                                                deleted_at = NOW()
                                            WHERE
                                                id NOT IN ({$ids}) AND
                                                client_id = ?");
        $stmt->bindValue(1, $clientId);

        return $stmt->execute() ? 1 : 0;
    }

    public function update($clientId, array $data): bool
    {
        $stmt = $this->connection->prepare("UPDATE contact SET type = ?, contact = ?, updated_at = NOW() WHERE id = ? AND client_id = ?");
        $stmt->bindValue(1, $data['type']);
        $stmt->bindValue(2, $data['contact']);
        $stmt->bindValue(3, $data['id']);
        $stmt->bindValue(4, $clientId);

        return $stmt->execute() ? 1 : 0;
    }
}