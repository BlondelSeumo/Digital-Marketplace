<?php

namespace Vironeer\NOWPayments\Endpoint;

class Currency extends AbstractEndpoint
{
    const RESOURCE = 'currencies';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function get(): array
    {
        return $this->request(parent::METHOD_GET);
    }
}
