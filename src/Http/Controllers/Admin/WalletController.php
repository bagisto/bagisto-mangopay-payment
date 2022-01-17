<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;

class WalletController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * MangopayAdminWalletRepository object
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
    * @param  \Webkul\MangoPay\Repositories\MangopayWalletRepository  $mangopayWalletRepository
    * @param  \Webkul\MangoPay\Helpers\MangopayHelper $mangopayHelper
    * @return void
     */
    public function __construct(
        MangopayHelper $mangopayHelper,
        MangopayWalletRepository $mangopayWalletRepository
    )
    {
        $this->mangopayWalletRepository = $mangopayWalletRepository;

        $this->mangopayHelper = $mangopayHelper;

        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = $this->mangopayWalletRepository->where('admin_id',auth()->guard('admin')->user()->id)->first();
      
        return view($this->_config['view'],compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       $adminData = auth()->guard('admin')->user();

       $admin = [
           "fname" => $adminData->name,
           "lname" => $adminData->name,
           "email" => $adminData->email,
           "usertype" => $adminData->role->name
       ];

       $this->mangopayHelper->createAdminDetail($admin);

       session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Wallet Id and MangoPay Id ']));
      
       return redirect()->route($this->_config['redirect']);
    }
}
