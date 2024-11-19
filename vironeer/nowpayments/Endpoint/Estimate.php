<?php

namespace Vironeer\NOWPayments\Endpoint;

class Estimate extends AbstractEndpoint
{
    const RESOURCE = 'estimate';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function get(array $query): array
    {
        return $this->request(parent::METHOD_GET, null, [], $query);
    }
}
