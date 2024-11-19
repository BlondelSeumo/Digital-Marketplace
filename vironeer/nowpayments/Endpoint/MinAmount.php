<?php

namespace Vironeer\NOWPayments\Endpoint;

class MinAmount extends AbstractEndpoint
{
    const RESOURCE = 'min-amount';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function get(array $query): array
    {
        return $this->request(parent::METHOD_GET, null, [], $query);
    }
}
