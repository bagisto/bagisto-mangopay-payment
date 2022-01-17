<?php

namespace Webkul\MangoPay\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\MangoPay\Helpers\PaymentProcessHelper;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\MangoPay\Repositories\EscrowedAmountRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Cart;

class MangoPayStandardController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;
 
    /**
     * MangopayHelper object
     *
     * @var Webkul\MangoPay\Helpers\MangopayHelper
     */
    protected $mangopayHelper;

    /**
     * MangopayHelper object
     *
     * @var Webkul\MangoPay\Helpers\PaymentProcessHelper
     */
    protected $paymentProcessHelper;

    /**
     * OrderRepository $orderRepository
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * InvoiceRepository $orderRepository
     *
     * @var \Webkul\Sales\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

     /**
     * EscrowedAmountRepository $escrowedAmountRepository
     *
     * @var  Webkul\MangoPay\Repositories\EscrowedAmountRepository
     */
    protected $escrowedAmountRepository;

    /**
     * MangopayWalletRepository object
     * 
     * @var \Webkul\MangoPay\Repositories\MangopayWalletRepository
     */
    protected $mangopayWalletRepository;   

    /**
     * Create a new controller instance.
     *
     *  @param \Webkul\MangoPay\Helpers\PaymentProcessHelper $paymentProcessHelper
     *  @param \Webkul\MangoPay\Helpers\MangopayHelper $mangopayHelper
     *  @param \Webkul\Sales\Repositories\OrderRepository $orderRepository
     *  @param \Webkul\Sales\Repositories\InvoiceRepository $invoiceRepository
     *  @param \Webkul\MangoPay\Repositories\EscrowedAmountRepository $escrowedAmountRepository
     *  @param \Webkul\MangoPay\Repositories\MangopayWalletRepository $mangopayWalletRepository
     * @return void
     */
    public function __construct(
        MangopayHelper $mangopayHelper,
        PaymentProcessHelper $paymentProcessHelper,
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository,
        EscrowedAmountRepository $escrowedAmountRepository,
        MangopayWalletRepository $mangopayWalletRepository
    )                                                                                       
    {
        $this->mangopayHelper = $mangopayHelper;

        $this->paymentProcessHelper = $paymentProcessHelper;

        $this->orderRepository = $orderRepository;

        $this->invoiceRepository = $invoiceRepository;

        $this->escrowedAmountRepository = $escrowedAmountRepository;

        $this->mangopayWalletRepository = $mangopayWalletRepository;
       
        $this->_config = request('_config');
    }

    /**
     * Redirects to the paypal.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('mangopay::shop.checkout.mangopay-redirect');
    }

    /**
     * Cancel payment from paypal.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', 'Mangopay payment has been canceled.');

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        $this->processOrder($order);

        $wallet = '';

        if($order->customer_id) {
            $wallet = $this->mangopayWalletRepository->where('customer_id',$order->customer_id)->first();
    
        }else{
            $wallet = $this->mangopayWalletRepository->where('cart_id',$order->cart_id)->first();
        }
       
        $this->escrowedAmountRepository->create([
            'order_id' => $order->id,
            'wallet_id' => $wallet->wallet_id,
            'escrowed_amount' => $order->grand_total,
            'payin_id' => session()->get('payin_id') ,
            'transaction_id' => request()->transactionId,
        ]);
       
        Cart::deActivateCart();

        session()->flash('order', $order);

        return redirect()->route('shop.checkout.success');
    }

    /**
     * Redirects to the paypal.
     *
     * @return \Illuminate\View\View
     */
    public function redirectMangoPay()
    {
       return $this->paymentProcessHelper->authorize();
    }

      /**
     * Process order and create invoice
     *
     * @return void
     */
    protected function processOrder($order)
    {      
        $this->orderRepository->update(['status' => 'processing'], $order->id);

        if ($order->canInvoice()) {
            $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));
        }
    }

    /**
     * Prepares order's invoice data for creation
     *
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ["order_id" => $order->id,];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
