<?php

namespace Webkul\MangoPay\Payment;

use Illuminate\Support\Facades\Storage;
use Webkul\Payment\Payment\Payment;

abstract class Mangopay extends Payment
{
    /**
     * Get the route that sends the customer on to MangoPay.
     *
     * @param  array  $params
     * @return string
     */
    public function getMangoPayUrl($params = [])
    {
        return route('mangopay.standard.redirect_mangopay');
    }

    /**
     * Get payment method image URL.
     *
     * @return string
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url
            ? Storage::url($url)
            : asset('themes/mangopay/images/mangopay.svg');
    }
}
