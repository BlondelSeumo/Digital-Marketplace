<?php

namespace Vironeer\NOWPayments;

use Vironeer\NOWPayments\Endpoint;

class Client
{
    const API_ENDPOINT = 'https://api.nowpayments.io';
    const API_SANDBOX_ENDPOINT = 'https://api-sandbox.nowpayments.io';

    const API_VERSION = 'v1';

    private $apiKey;

    private $testModus;

    public function __construct(string $apiKey, bool $testModus = false)
    {
        $this->apiKey = $apiKey;
        $this->testModus = $testModus;

        $this->initializeEndpoints();
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getApiEndpoint(): string
    {
        if ($this->testModus) {
            return self::API_SANDBOX_ENDPOINT;
        }

        return self::API_ENDPOINT;
    }

    private function initializeEndpoints()
    {
        $this->status = new Endpoint\Status($this);
        $this->currency = new Endpoint\Currency($this);
        $this->payment = new Endpoint\Payment($this);
        $this->estimate = new Endpoint\Estimate($this);
        $this->invoice = new Endpoint\Invoice($this);
        $this->minAmount = new Endpoint\MinAmount($this);
    }
}
