<?php

namespace Webkul\MangoPay\Helpers;

use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Cart;

class PaymentProcessHelper 
{
    const METHOD_CODE = 'mpmangopay';

    const GUEST_ID = 0;

    /**
     * @var string
     */
    protected $_code = self::METHOD_CODE;

    
    /**
     * MangopayHelper object
     *
     * @var Webkul\MangoPay\Helpers\MangopayHelper
     */
    protected $mangopayHelper;

    /**
     * MangopayWalletRepository object
     *
     * @var \Webkul\MangoPay\Repositories\MangopayWalletRepository
     */
    protected $mangopayWalletRepository;   
 
    /**
     * Create a new helper instance.
     * @param  \Webkul\MangoPay\Repositories\MangopayWalletRepository  $mangopayWalletRepository
     * @param  \ Webkul\MangoPay\Helpers\MangopayHelper $mangopayHelper
     * @return void
     */
    public function __construct(
        MangopayWalletRepository $mangopayWalletRepository,
        MangopayHelper $mangopayHelper
    ) {
      $this->mangopayWalletRepository = $mangopayWalletRepository;
      $this->mangopayHelper = $mangopayHelper;
    }
    /**
     * Checkout order place redirect URL getter.
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
        return route('mangopay.standard.success');
    }

    /**
     * Authorizes specified amount.
     *
     * @param InfoInterface $payment
     * @param float         $amount
     *
     * @return $this
     *
     * @throws LocalizedException
     */
    public function authorize()
    {
        $cart = Cart::getCart();

        $cardType = 'CB_VISA_MASTERCARD';
        $paymentType = "CARD";

        $customerEmail = $cart->customer_email;
        $customerId = $cart->customer_id;

        $mpUserColl = '';

        if ($customerId=="") {
            //Check if user already created on mangopay
            $mpUserColl = $this->mangopayWalletRepository->where('cart_id',$cart->id)->first();
        }else{
            //Check if user already created on mangopay
            $mpUserColl = $this->mangopayWalletRepository->where('customer_id',$customerId)->first();
        }  
         
        if (! empty($mpUserColl)) {            
            $mangopayId = $mpUserColl->mangopay_id;
            $walletId = $mpUserColl->wallet_id;
        } else {
            $wholeData= $this->getCustomerDataByOrder();
            $wholeData['customer_id'] = $customerId;
            $result=$this->mangopayHelper->createNatural($wholeData);
            $mpData= explode('split', $result);
            $mangopayId = $mpData[1];
            $walletId = $mpData[2];
        }

        $result = '';
        $fees = 0;
        
        if ($paymentType=="CARD"){
            $result =  $this->mangopayHelper->makeCardpayment($cardType, $mangopayId, $walletId, $cart->grand_total, $fees);
        
            session()->put('payin_id' ,$result->Id);
        }

        if ( isset($result) && $result->ExecutionDetails->RedirectURL=="") {
            return redirect()->route('mangopay.standard.cancel');
        } else {
           return \Redirect::to($result->ExecutionDetails->RedirectURL);
        }

        try {

        } catch (\Exception $e) {
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
        return $this;
    }


    /**
     * @return $array
     *
     * @throws LocalizedException
     */

    public function getCustomerDataByOrder() {
        
        $cart = Cart::getCart();

        return [
            "fname" => $cart->customer_first_name,
            "lname" => $cart->customer_last_name,
            "country_id" => "IN",
            "email" => $cart->customer_email,
            "usertype" => "Customer",
            "description" => "Customer Create Wallet" 
        ];
    }

}