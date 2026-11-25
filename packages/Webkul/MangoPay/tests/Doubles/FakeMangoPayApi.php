<?php

namespace Webkul\MangoPay\Tests\Doubles;

use MangoPay\MangoPayApi;

class FakeMangoPayApi extends MangoPayApi
{
    /**
     * Every call made against the fake, in order: service, method, first argument and all arguments.
     */
    public static array $calls = [];

    /**
     * Canned answers keyed `Service.Method`: an object, or a closure receiving the call's arguments.
     */
    public static array $responses = [];

    /**
     * When set, the next service call throws this instead of answering.
     */
    public static ?\Throwable $throw = null;

    /**
     * Swap the SDK services the module uses for recorders that never reach the network.
     */
    public function __construct()
    {
        parent::__construct();

        $this->Users = new FakeService('Users');
        $this->Wallets = new FakeService('Wallets');
        $this->PayIns = new FakeService('PayIns');
        $this->Transfers = new FakeService('Transfers');
    }

    /**
     * Forget everything recorded or configured by a previous test.
     */
    public static function reset(): void
    {
        static::$calls = [];

        static::$responses = [];

        static::$throw = null;
    }

    /**
     * The argument handed to the first matching call, or null when it never happened.
     */
    public static function firstArgument(string $service, string $method): mixed
    {
        foreach (static::$calls as $call) {
            if (
                $call['service'] === $service
                && $call['method'] === $method
            ) {
                return $call['argument'];
            }
        }

        return null;
    }

    /**
     * Every recorded call of the given service method, in order.
     */
    public static function callsTo(string $service, string $method): array
    {
        return array_values(array_filter(
            static::$calls,
            fn ($call) => $call['service'] === $service && $call['method'] === $method
        ));
    }

    /**
     * Whether the given service method was called.
     */
    public static function called(string $service, string $method): bool
    {
        return static::callsTo($service, $method) !== [];
    }
}
