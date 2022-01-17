<?php

namespace Webkul\MangoPay\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\MangoPay\Repositories\MangopayBankDetailsRepository;
use Webkul\MangoPay\Repositories\MangopayKycRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\MangoPay\Helpers\MangopayHelper;

class MangoPayController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * MangopayBankDetailsRepository
     *
     * @var object
     */
    protected $mangopayBankDetailsRepository;

    /**
     * MangopayKycRepository
     *
     * @var object
     */
    protected $mangopayKycRepository;

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
     *  @param \Webkul\MangoPay\Repositories\MangopayBankDetailsRepository $mangopayBankDetailsRepository
     *  @param \Webkul\MangoPay\Repositories\MangopayKycRepository $mangopayKycRepository
     *  @param \Webkul\MangoPay\Repositories\MangopayWalletRepository $mangopayWalletRepository
     *  @param \Webkul\MangoPay\Helpers\MangopayHelper $mangopayHelper
     * @return void
     */
    public function __construct(
        MangopayBankDetailsRepository $mangopayBankDetailsRepository,
        MangopayKycRepository $mangopayKycRepository,
        MangopayHelper $mangopayHelper,
        MangopayWalletRepository $mangopayWalletRepository
    )                                                                                       
    {
        $this->mangopayWalletRepository = $mangopayWalletRepository;

        $this->mangopayHelper = $mangopayHelper;

        $this->mangopayBankDetailsRepository = $mangopayBankDetailsRepository;

        $this->mangopayKycRepository = $mangopayKycRepository;

        $this->_config = request('_config');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function bankdetails()
    {
        $user = auth()->guard('customer')->user();

        $seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();

        $data = $this->mangopayBankDetailsRepository->where('seller_id',$seller->id)->first();
    
        return view($this->_config['view'],compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function storeBankdetails()
    {
        $user = auth()->guard('customer')->user();

        $data = request()->except('_token');
       
        $oldData = $this->mangopayBankDetailsRepository->where('seller_id',request()->seller_id)->first();

        $wallet = $this->mangopayWalletRepository->where('seller_id',request()->seller_id)->first();
    
        if(! isset($wallet)) {

            $user = auth()->guard('customer')->user();

            $seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();

            if( isset($seller)) {
 
                $seller = [
                    "fname" => $user->first_name,
                    "lname" => $user->last_name,
                    "email" => $user->email,
                    "usertype" => "Seller",
                    "dob" => $user->date_of_birth,
                    "description" => "Seller Create Wallet"
                ];
         
              $wallet = $this->mangopayHelper->createLegal($seller);
            }           
        }

        $result  = $this->mangopayHelper->saveBankdetail($wallet->mangopay_id,$data);
  
        if(isset($result)) {
            $this->mangopayBankDetailsRepository->create(array_merge($data, ['bank_id' => $result->Id]));

            if( isset($oldData)) {
                $this->mangopayBankDetailsRepository->whereId($oldData->id)->delete();
            }
        }else {
            session()->flash('error', 'Something went wrong');
        
            return redirect()->route($this->_config['redirect']);
        }

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Bank Details']));
        
        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function kyc()
    {
        return view($this->_config['view']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function createKyc()
    {
        return view($this->_config['view']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function storeKyc()
    {   
        $data = request()->except('_token');

        if(! request()->hasFile('file')) {
            session()->flash('error', 'File is Required');
        
            return redirect()->route($this->_config['redirect']);
        }

        $wallet = $this->mangopayWalletRepository->where('seller_id',request()->seller_id)->first();
    
        if(! isset($wallet)) {
            session()->flash('success', 'Please Submit Bank details First');
        
            return redirect()->route($this->_config['redirect']);
        }

        $array = [
            "type" => request()->type,
            "file" => base64_encode(file_get_contents(request()->file('file')))
        ];

        try{
            $result = $this->mangopayHelper->saveKycDocument($wallet->mangopay_id,$array); 
       
        }catch (Exception $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->route($this->_config['redirect']);
        }   
       

        $file = 'file';
        $dir = 'kyc/' . request()->seller_id;

        $data = '';

        if( isset($result->Id)) {
            if (request()->hasFile($file)) {
                $this->mangopayKycRepository->create([
                    'file'      => request()->file($file)->store($dir),
                    'type'      => request()->type,
                    'seller_id' => request()->seller_id,
                    'mangopay_file_id' => $result->Id,
                    'status'  => $result->Status
                ]);
            }
        }else{
            session()->flash('error', 'Something Went Wrong');
        
            return redirect()->route($this->_config['redirect']);
        }     
      
        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Kyc']));
        
        return redirect()->route($this->_config['redirect']);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function transactions()
    {
        return view($this->_config['view']);
    }
}
