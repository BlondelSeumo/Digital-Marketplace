<?php

namespace Vironeer\NOWPayments\Endpoint;

class Status extends AbstractEndpoint
{
    const RESOURCE = 'status';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function get(): array
    {
        return $this->request(parent::METHOD_GET);
    }
}
