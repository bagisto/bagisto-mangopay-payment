<?php

namespace Webkul\MangoPay\Tests\Doubles;

class FakeService
{
    /**
     * Create a recorder for one SDK service.
     */
    public function __construct(protected string $name) {}

    /**
     * Record the call and answer with the configured or the canned object.
     */
    public function __call(string $method, array $arguments): object
    {
        FakeMangoPayApi::$calls[] = [
            'service' => $this->name,
            'method' => $method,
            'argument' => $arguments[0] ?? null,
            'arguments' => $arguments,
        ];

        if (FakeMangoPayApi::$throw) {
            $throw = FakeMangoPayApi::$throw;

            FakeMangoPayApi::$throw = null;

            throw $throw;
        }

        $response = FakeMangoPayApi::$responses[$this->name.'.'.$method] ?? null;

        if ($response instanceof \Closure) {
            return $response(...$arguments);
        }

        return $response ?? $this->response($method);
    }

    /**
     * The shape the module reads back off each call; the identifiers are invented.
     */
    protected function response(string $method): object
    {
        $response = new \stdClass;

        $response->Id = match (true) {
            $this->name === 'Users' && $method === 'Create' => 'user-1001',
            $this->name === 'Users' && $method === 'CreateBankAccount' => 'bank-2002',
            $this->name === 'Users' && str_contains($method, 'Kyc') => 'kyc-3003',
            $this->name === 'Wallets' => 'wallet-4004',
            $this->name === 'PayIns' && $method === 'CreateRefund' => 'refund-6006',
            $this->name === 'PayIns' => 'payin-5005',
            $this->name === 'Transfers' => 'transfer-7007',
            default => 'id-9009',
        };

        if (
            $this->name === 'Users'
            && str_contains($method, 'Kyc')
        ) {
            $response->UserId = 'user-1001';
        }

        $response->Status = $this->name === 'Transfers' ? 'SUCCEEDED' : 'CREATED';
        $response->ExecutionDetails = new \stdClass;
        $response->ExecutionDetails->RedirectURL = 'https://sandbox.example/redirect/'.$response->Id;

        return $response;
    }
}
