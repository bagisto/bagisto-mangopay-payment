<?php

namespace Webkul\MangoPay\Payment;

use Webkul\MangoPay\Payment\Mangopay;

class Standard extends Mangopay
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'mangopay_standard';


    /**
     * Return paypal redirect url
     *
     * @return string
     */
    public function getRedirectUrl()
    {
       return route('mangopay.standard.redirect');
    }

     /**
     * Checks if payment method is available
     *
     * @return array
     */
    public function isAvailable()
    {
        if( core()->getConfigData('mangopay.general.general.active')) {
            return $this->getConfigData('active');
        }        
    }
}