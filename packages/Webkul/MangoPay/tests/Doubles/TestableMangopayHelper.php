<?php

namespace Webkul\MangoPay\Tests\Doubles;

use MangoPay\MangoPayApi;
use Webkul\MangoPay\Helpers\MangopayHelper;

class TestableMangopayHelper extends MangopayHelper
{
    /**
     * Replace only the helper's network seam, so every other line of it runs for real.
     */
    protected function initApi(): MangoPayApi
    {
        return new FakeMangoPayApi;
    }
}
