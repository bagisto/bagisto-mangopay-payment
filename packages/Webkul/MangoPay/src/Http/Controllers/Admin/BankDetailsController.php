<?php

namespace Webkul\MangoPay\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\MangopayBankDetailsRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;

class BankDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected MangopayBankDetailsRepository $bankDetailsRepository,
        protected MangopayHelper $mangopayHelper,
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $admin = auth()->guard('admin')->user();

        $bankdetail = $this->bankDetailsRepository->adminBankDetails();

        return view('mangopay::admin.bank.index', compact('bankdetail', 'admin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'in:'.implode(',', MangopayHelper::BANK_ACCOUNT_TYPES)],
        ]);

        $adminId = auth()->guard('admin')->id();

        $data = $request->only(MangopayHelper::BANK_DETAIL_FIELDS);

        $wallet = $this->mangopayWalletRepository->adminWallet();

        if (! $wallet) {
            session()->flash('error', trans('mangopay::app.admin.response.wallet-not-found'));

            return redirect()->route('admin.mangopay.save_bank_details');
        }

        try {
            $oldData = $this->bankDetailsRepository->adminBankDetails();

            $result = $this->mangopayHelper->saveBankdetail(
                $wallet->mangopay_id,
                $data
            );

            $this->bankDetailsRepository->create(
                array_merge($data, [
                    'admin_id' => $adminId,
                    'bank_id' => $result->Id,
                ])
            );

            if ($oldData) {
                $this->bankDetailsRepository->delete($oldData->id);
            }

            session()->flash(
                'success',
                trans('mangopay::app.admin.response.bank-details-create-success')
            );
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('admin.mangopay.save_bank_details');
    }
}
