<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected MangopayHelper $mangopayHelper,
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Display wallet details.
     */
    public function index(): View
    {
        $data = $this->mangopayWalletRepository->adminWallet();

        return view('mangopay::admin.wallet.index', compact('data'));
    }

    /**
     * Create the store's MangoPay wallet once; an existing wallet is never replaced.
     */
    public function create(): RedirectResponse
    {
        if ($this->mangopayWalletRepository->adminWallet()) {
            session()->flash('error', trans('mangopay::app.admin.response.wallet-exists'));

            return redirect()->route('admin.mangopay.wallet');
        }

        $admin = auth()->guard('admin')->user();

        try {
            $this->mangopayHelper->createAdminDetail([
                'fname' => $admin->name,
                'lname' => $admin->name,
                'email' => $admin->email,
                'usertype' => $admin->role->name,
            ]);

            session()->flash(
                'success',
                trans('mangopay::app.admin.response.wallet-create-success')
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.mangopay.wallet');
    }
}
