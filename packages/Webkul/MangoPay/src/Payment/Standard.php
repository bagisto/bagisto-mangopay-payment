<?php

namespace Webkul\MangoPay\Payment;

class Standard extends Mangopay
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'mangopay_standard';

    /**
     * Get the checkout redirect URL.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('mangopay.standard.redirect');
    }

    /**
     * Offer the method only when it is enabled and its API credentials are configured.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return (bool) $this->getConfigData('active')
            && ! empty($this->getConfigData('clientid'))
            && ! empty($this->getConfigData('passphrase'));
    }
}
