<?php

namespace SRC\Domain\Client;

use SRC\Domain\Client\Interfaces\ContactCreateRepository;
use SRC\Domain\Client\Interfaces\ContactDeleteRepository;
use SRC\Domain\Client\Interfaces\ContactUpdateRepository;

class ContactUpdateHandler
{
    private $repository;

    private $contactCreate;

    private $contactDelete;

    public function __construct(
        ContactUpdateRepository $repository,
        ContactCreateRepository $contactCreateRepository,
        ContactDeleteRepository $contactDeleteRepository
    )
    {
        $this->repository = $repository;
        $this->contactCreate = new ContactCreateHandler($contactCreateRepository);
        $this->contactDelete = new ContactDeleteHandler($contactDeleteRepository);
    }

    public function update($clientId, $data)
    {
        $ids = [];
        foreach ($data as $contact) {
            if (empty($contact['id'])) {
                $ids[] = $this->contactCreate->create($clientId, $contact);

                continue;
            }

            $this->repository->update($clientId, $contact);
            $ids[] = $contact['id'];
        }

        $this->contactDelete->delete($clientId, implode(', ', $ids));
    }
}