<?php

namespace Vironeer\NOWPayments\Endpoint;

class Invoice extends AbstractEndpoint
{
    const RESOURCE = 'invoice';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function create(array $data): array
    {
        return $this->request(parent::METHOD_POST, null, $data);
    }
}
