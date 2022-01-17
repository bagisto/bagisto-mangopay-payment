<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\MangoPay\Helpers\ReleaseAmount;

class TransactionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    
    /**
     * ReleaseAmount object
     *
     * @var Webkul\MangoPay\Helpers\ReleaseAmount
     */
    protected $releaseAmount;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\MangoPay\Helpers\ReleaseAmount $releaseAmount
     * @return void
     */
    public function __construct(
        ReleaseAmount $releaseAmount
    )
    {
        $this->releaseAmount = $releaseAmount;

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
        return view($this->_config['view']);
    }

     /**
     * Display a listing of the resource.
     */
    public function releaseAmount()
    {
        $data = request()->except('_token');

        $this->releaseAmount->execute($data);

        return redirect()->route('admin.mangopay.amount');
    }
}



