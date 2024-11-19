<?php

namespace Vironeer\NOWPayments\Endpoint;

class Payment extends AbstractEndpoint
{
    const RESOURCE = 'payment';

    public function getResource(): string
    {
        return self::RESOURCE;
    }

    public function create(array $data): array
    {
        return $this->request(parent::METHOD_POST, null, $data);
    }

    public function get(int $paymentId): array
    {
        return $this->request(parent::METHOD_GET, $paymentId);
    }

    public function list(array $query): array
    {
        return $this->request(parent::METHOD_GET, null, [], $query);
    }
}
