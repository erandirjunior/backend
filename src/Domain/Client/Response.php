<?php

namespace SRC\Domain\Client;

interface Response
{
    public function setBody($body = []);

    public function setCode($code);
}