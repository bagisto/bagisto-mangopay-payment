<?php

namespace Webkul\MangoPay\Payment;

use Illuminate\Support\Facades\Config;
use Webkul\Payment\Payment\Payment;

abstract class Mangopay extends Payment
{
    /**
     * PayPal web URL generic getter
     *
     * @param  array  $params
     * @return string
     */
    public function getMangoPayUrl($params = [])
    {
       return route('mangopay.standard.redirect-mangopay');
    }
}