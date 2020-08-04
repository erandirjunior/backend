<?php

namespace SRC\Infrastructure\Validator;

class ClientValidator implements \SRC\Domain\Client\ClientValidator
{
    private $errors;

    public function __construct()
    {
        $this->errors = [];
    }

    public function validate(\SRC\Domain\Client\ClientBoundery $clientBoundery): bool
    {
        if (empty($clientBoundery->getName())) {
            $this->errors[] = 'Campo nome não pode ser vazio';
        }

        if (empty($clientBoundery->getIdentifier())) {
            $this->errors[] = 'Campo de CPF/CNPJ não pode ser vazio';
        }

        return !!$this->errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }

}