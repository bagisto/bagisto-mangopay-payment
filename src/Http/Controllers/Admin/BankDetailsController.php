<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\MangoPay\Repositories\MangopayBankDetailsRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\MangoPay\Helpers\MangopayHelper;

class BankDetailsController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;


    /**
     * BankDetailsRepository object
     *
     * @var array
     */
    protected $bankDetailsRepository;

      /**
     * MangopayWalletRepository object
     * 
     * @var \Webkul\MangoPay\Repositories\MangopayWalletRepository
     */
    protected $mangopayWalletRepository;   

    /**
     * MangopayHelper object
     *
     * @var Webkul\MangoPay\Helpers\MangopayHelper
     */
    protected $mangopayHelper;


    /**
     * Create a new controller instance.
     *
     * @param \Webkul\MangoPay\Repositories\BankDetailsRepository  $bankDetailsRepository
     * @param \Webkul\MangoPay\Helpers\MangopayHelper  $mangopayHelper
     * @param \Webkul\MangoPay\Repositories\MangopayWalletRepository  $mangopayWalletRepository
     * @return void
     */
    public function __construct(
        MangopayBankDetailsRepository $bankDetailsRepository,
        MangopayHelper $mangopayHelper,
        MangopayWalletRepository $mangopayWalletRepository
    )
    {
        $this->mangopayWalletRepository = $mangopayWalletRepository;

        $this->mangopayHelper = $mangopayHelper;

        $this->middleware('admin');

        $this->_config = request('_config');

        $this->bankDetailsRepository = $bankDetailsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();

        $bankdetail = $this->bankDetailsRepository->where('admin_id',$admin->id)->first();

        return view($this->_config['view'],compact('bankdetail','admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->except('_token');

        $wallet = $this->mangopayWalletRepository->where('admin_id',auth()->guard('admin')->user()->id)->first();
    
        if(! isset($wallet)) {
            session()->flash('success', 'Please Create Wallet ID First');
        
            return redirect()->route($this->_config['redirect']);
        }

        $oldData = $this->bankDetailsRepository->where('admin_id',request()->admin_id)->first();

        $result  = $this->mangopayHelper->saveBankdetail($wallet->mangopay_id,$data);
  
        if(isset($result)) {
            $this->bankDetailsRepository->create(array_merge($data, ['bank_id' => $result->Id]));

            if( isset($oldData)) {
                $this->bankDetailsRepository->whereId($oldData->id)->delete();
            }
        }else {
            session()->flash('error', 'Something went wrong');
        
            return redirect()->route($this->_config['redirect']);
        }
  
        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Bank Details']));
        
        return redirect()->route($this->_config['redirect']);
    }
}
