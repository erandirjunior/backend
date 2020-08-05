<?php

namespace SRC\Infrastructure\Repository;

use SRC\Domain\Client\Interfaces\ClientBoundery;
use SRC\Domain\Client\Interfaces\ClientCreateRepository;
use SRC\Domain\Client\Interfaces\ClientDeleteRepository;
use SRC\Domain\Client\Interfaces\ClientFindAllRepository;
use SRC\Domain\Client\Interfaces\ClientFindRepository;
use SRC\Domain\Client\Interfaces\ClientUpdateRepository;

class ClientRepository implements
    ClientCreateRepository,
    ClientFindAllRepository,
    ClientFindRepository,
    ClientDeleteRepository,
    ClientUpdateRepository
{
    private $connection;

    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    public function create(\SRC\Domain\Client\Interfaces\ClientBoundery $clientBoundery): int
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
        $stmt = $this->connection->query("SELECT
                                            name,
                                            id,
                                            type,
                                            identifier
                                        FROM
                                            client
                                        WHERE
                                            deleted_at IS NULL");


        return $stmt->execute() ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
    }

    public function findById($id): array
    {
        $stmt = $this->connection->prepare("SELECT
                                            C.name,
                                            C.id,
                                            C.type as typePerson,
                                            C.identifier,
                                            CT.type,
                                            CT.contact,
                                            CT.id as contactId
                                        FROM
                                            client C
                                            LEFT JOIN contact CT ON CT.client_id = C.id AND CT.deleted_at IS NULL
                                        WHERE
                                            C.deleted_at IS NULL AND
                                            C.id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = [];

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $data['name'] = $row['name'];
            $data['identifier'] = $row['identifier'];
            $data['id'] = $row['id'];
            $data['typePerson'] = $row['typePerson'];
            $data['contact'][] = [
                'type' => $row['type'],
                'id' => $row['contactId'],
                'contact' => $row['contact'],
            ];
        }

        return $data;
    }

    public function delete($id): bool
    {
        $stmt = $this->connection->prepare("UPDATE client SET deleted_at = NOW() WHERE id = ?");
        $stmt->bindValue(1, $id);

        return $stmt->execute() ? true : false;
    }

    public function update(int $id, ClientBoundery $clientBoundery): bool
    {
        $stmt = $this->connection->prepare("UPDATE
                                                client
                                            SET
                                                name = ?,
                                                type = ?,
                                                identifier = ?,
                                                updated_at = NOW()
                                            WHERE
                                                id = ?");
        $stmt->bindValue(1, $clientBoundery->getName());
        $stmt->bindValue(2, $clientBoundery->getTypePerson());
        $stmt->bindValue(3, $clientBoundery->getIdentifier());
        $stmt->bindValue(4, $id);

        return $stmt->execute() ? 1 : 0;
    }

    public function checkIfHasOtherClientWithTheSameIdentifier(int $id, string $identifier): bool
    {
        $stmt = $this->connection->prepare("SELECT id FROM client WHERE identifier = ? AND id != ? AND deleted_at IS NULL");
        $stmt->bindValue(1, $identifier);
        $stmt->bindValue(2, $id);
        $stmt->execute();
        return !!$stmt->fetch();
    }
}