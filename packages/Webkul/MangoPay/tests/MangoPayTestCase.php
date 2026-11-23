<?php

namespace Webkul\MangoPay\Tests;

use Tests\TestCase;
use Webkul\Admin\Tests\Concerns\AdminTestBench;
use Webkul\MangoPay\Tests\Concerns\ProvideMangoPayHelpers;
use Webkul\Shop\Tests\Concerns\ShopTestBench;

class MangoPayTestCase extends TestCase
{
    use AdminTestBench, ProvideMangoPayHelpers, ShopTestBench;
}
