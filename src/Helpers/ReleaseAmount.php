<?php

namespace Webkul\MangoPay\Helpers;

use Webkul\Marketplace\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderRepository as BaseOrderRepository;
use Webkul\MangoPay\Repositories\EscrowedAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\Marketplace\Repositories\ProductRepository;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\MangopayTransferAmountRepository;

class ReleaseAmount
{
    /**
     * OrderRepository $orderRepository
     *
     * @var \Webkul\MArketplace\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * OrderRepository as BaseOrderRepository $orderRepository
     *
     * @var \Webkul\Sales\Repositories\OrderRepository as BaseOrderRepository
     */
    protected $baseOrderRepository;

    /**
     * EscrowedAmountRepository $escrowedAmountRepository
     *
     * @var  Webkul\MangoPay\Repositories\EscrowedAmountRepository
     */
    protected $escrowedAmountRepository;

    /**
     * MangopayTransferAmountRepository $mangopayTransferAmountRepository
     *
     * @var  Webkul\MangoPay\Repositories\MangopayTransferAmountRepository
     */
    protected $mangopayTransferAmountRepository;

    /**
     * MangopayWalletRepository object
     * 
     * @var \Webkul\MangoPay\Repositories\MangopayWalletRepository
     */
    protected $mangopayWalletRepository;  

    /**
     * ProductRepository object
     * 
     * @var  \Webkul\Marketplace\Repositories\ProductRepository
     */
    protected $productRepository;  

     /**
     * MangopayHelper object
     *
     * @var Webkul\MangoPay\Helpers\MangopayHelper
     */
    protected $mangopayHelper;

    /**
     * Create a new controller instance.
     * 
     * @param \Webkul\Marketplace\Repositories\OrderRepository $orderRepository
     * @param \Webkul\Sales\Repositories\OrderRepository as BaseOrderRepository $baseOrderRepository
     * @param \Webkul\MangoPay\Repositories\EscrowedAmountRepository $escrowedAmountRepository
     * @param \Webkul\MangoPay\Repositories\MangopayWalletRepository $mangopayWalletRepository
     * @param \Webkul\Marketplace\Repositories\ProductRepository $productRepository
     * @param \Webkul\MangoPay\Helpers\MangopayHelper  $mangopayHelper   * 
     * @param \Webkul\MangoPay\Repositories\MangopayTransferAmountRepository  $mangopayTransferAmountRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        EscrowedAmountRepository $escrowedAmountRepository,
        MangopayWalletRepository $mangopayWalletRepository,
        ProductRepository $productRepository,
        BaseOrderRepository $baseOrderRepository,
        MangopayHelper $mangopayHelper,
        MangopayTransferAmountRepository $mangopayTransferAmountRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->escrowedAmountRepository  = $escrowedAmountRepository;
        $this->mangopayWalletRepository = $mangopayWalletRepository;
        $this->productRepository = $productRepository;
        $this->baseOrderRepository = $baseOrderRepository;
        $this->mangopayHelper = $mangopayHelper;
        $this->mangopayTransferAmountRepository = $mangopayTransferAmountRepository;
    }

    /**
     * Escrow Detail Page
     *
     * @return
     */
    public function execute($data)
    {
        $escrow = $this->escrowedAmountRepository->find($data['id']);

        $order = $this->baseOrderRepository->find($escrow->order_id);

        $buyerData = '';

        if($order->customer_id) {
            $buyerData = $this->mangopayWalletRepository->where('customer_id',$order->customer_id)->first();
        }else{
            $buyerData = $this->mangopayWalletRepository->where('cart_id',$order->cart_id)->first();
        }
       
        $payinId = $escrow->payin_id;
        $orderId = $escrow->order_id;
             
        $buyerMangopayId = $buyerData->mangopay_id;
        $buyerWalletId = $buyerData->wallet_id;

        $sellerData = [];
        $adminData  = [];

        foreach($order->items as $item) {

            $seller = $this->productRepository->getSellerByProductId($item->product_id);

            if( isset($seller) &&$seller->is_approved) {
                $sellerData[] = $this->orderRepository->where([
                    "marketplace_seller_id" => $seller->id,
                    "order_id" => $order->id
                ])->first();
            }else{
                $adminData[] = $item;
            }
        } 

        //transfer to admin wallet from buyer

        if( count($adminData) > 0) {

            $amount = 0;

            foreach($adminData as $adminOrder) {
                $amount = (float)$amount + (float)$adminOrder->base_total_invoiced;
            }

            $admin_collection = $this->mangopayWalletRepository->where('admin_id',auth()->guard('admin')->user()->id)->first();

            $fees=0;
            $sellerMangopayId= $admin_collection->mangopay_id;
            $sellerWalletId= $admin_collection->wallet_id;
            $Tag = "Transfer to admin from buyer";

            $transfer=$this->mangopayHelper->createTransfer(
                $buyerMangopayId,
                $buyerWalletId,
                $sellerMangopayId,
                $sellerWalletId,
                $Tag,
                $amount,
                $fees
            );

            if ($transfer->Status == 'SUCCEEDED') {

                $this->mangopayTransferAmountRepository->create([
                    'transaction_id' => $transfer->Id,
                    'amount' => (float)$amount,
                    'message' => $data['message'],
                    'status' => $transfer->Status,
                    'admin_id' => auth()->guard('admin')->user()->id,
                ]);

                $this->updateEscrowDetails($data['id']);

                session()->flash('success', 'Transfer Successfully done!');
            } else {
                
                session()->flash('warning',$transfer->Status);
            }
        }
        
         //transfer to seller from buyer
        foreach ($sellerData as $value) {

            $sellerId = $value->marketplace_seller_id;
            $amount = $value->seller_total_invoiced;

            $fees=0;
            $Tag = "Transaction to seller from buyer";

            $seller_collection = $this->mangopayWalletRepository->where('seller_id',$value->marketplace_seller_id)->first();

            $sellerMangopayId = '';
            $sellerWalletId = '';

            $sellerCommission = $value->commission_invoiced;
              
            if (!empty($seller_collection)) {               
                    $entityId = $seller_collection->mangopay_id;
                    $sellerMangopayId = $seller_collection->mangopay_id;
                    $sellerWalletId = $seller_collection->wallet_id;
            
            } else {

                $seller = app('Webkul\Marketplace\Repositories\SellerRepository')->find($value->marketplace_seller_id);

                $customer =  app('Webkul\Customer\Repositories\CustomerRepository')->find($seller->customer_id);
                
                $wholeData = [
                    "fname" => $customer->first_name,
                    "lname" => $customer->last_name,
                    "email" => $customer->email,
                    "usertype" => "Seller",
                    "dob" => $customer->date_of_birth,
                    "description" => "Seller Create Wallet"
                ];
         
                $result=$this->mangopayHelper->createLegal($wholeData);
                $mpData= explode('split', $result);
                $entityId=$mpData[0];
                $sellerMangopayId = $mpData[1];
                $sellerWalletId = $mpData[2];
            }
           
            //transfer to seller or admin wallet from buyer
            if ($amount > 0) {
                $transfer=$this->mangopayHelper->createTransfer(
                    $buyerMangopayId,
                    $buyerWalletId,
                    $sellerMangopayId,
                    $sellerWalletId,
                    $Tag,
                    $amount,
                    $fees
                );

                if ($transfer->Status == 'SUCCEEDED') {

                    $this->mangopayTransferAmountRepository->create([
                        'transaction_id' => $transfer->Id,
                        'amount' => $amount,
                        'message' => $data['message'],
                        'status' => $transfer->Status,
                        'seller_id' => $sellerId,
                    ]);

                    $this->updateEscrowDetails($data['id']);

                                
                    session()->flash('success', 'Transfer Successfully done!');
                } else {
                    
                    session()->flash('warning',$transfer->ResultMessage);

                }
            }

            if($sellerCommission) {

                $admin_collection = $this->mangopayWalletRepository->where('admin_id',auth()->guard('admin')->user()->id)->first();

                $amount = $sellerCommission;
                $fees=0;
                $sellerMangopayId= $admin_collection->mangopay_id;
                $sellerWalletId= $admin_collection->wallet_id;
                $Tag = "Commision to admin from buyer";

                $transfer=$this->mangopayHelper->createTransfer(
                    $buyerMangopayId,
                    $buyerWalletId,
                    $sellerMangopayId,
                    $sellerWalletId,
                    $Tag,
                    $amount,
                    $fees
                );

                if ($transfer->Status == 'SUCCEEDED') {

                    $this->mangopayTransferAmountRepository->create([
                        'transaction_id' => $transfer->Id,
                        'amount' => $amount,
                        'message' => $data['message'],
                        'status' => $transfer->Status,
                        'admin_id' => auth()->guard('admin')->user()->id,
                    ]);

                    $this->updateEscrowDetails($data['id']);

                    session()->flash('success', 'Transfer Successfully done!');

                } else {
                    
                    session()->flash('warning',$transfer->ResultMessage);

                }
            }           

        }        
    }

     /**
     * @param int $id
     * @return void
     */
    private function updateEscrowDetails($id)
    {
        $escrow = $this->escrowedAmountRepository->find($id);

        $escrow->status = 1;

        $escrow->save();

        return "";
    }
}