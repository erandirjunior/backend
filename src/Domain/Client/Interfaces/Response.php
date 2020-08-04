<?php

namespace SRC\Domain\Client\Interfaces;

interface Response
{
    public function setBody($body = []);

    public function setCode($code);
}