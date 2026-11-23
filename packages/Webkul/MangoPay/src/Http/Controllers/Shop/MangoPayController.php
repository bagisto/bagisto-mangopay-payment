<?php

namespace Webkul\MangoPay\Http\Controllers\Shop;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webkul\MangoPay\DataGrids\Shop\KycDatagrid;
use Webkul\MangoPay\DataGrids\Shop\TransactionDatagrid;
use Webkul\MangoPay\Helpers\MangopayHelper;
use Webkul\MangoPay\Repositories\MangopayBankDetailsRepository;
use Webkul\MangoPay\Repositories\MangopayKycRepository;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Webkul\Shop\Http\Controllers\Controller;

class MangoPayController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected MangopayBankDetailsRepository $mangopayBankDetailsRepository,
        protected MangopayKycRepository $mangopayKycRepository,
        protected MangopayHelper $mangopayHelper,
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Display bank details.
     */
    public function bankdetails(): View
    {
        $seller = $this->seller();

        $data = $this->mangopayBankDetailsRepository
            ->where('seller_id', $seller->id)
            ->first();

        return view('mangopay::seller.mangopay.bankdetails.index', compact('data', 'seller'));
    }

    /**
     * Store bank details.
     */
    public function storeBankdetails(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'in:'.implode(',', MangopayHelper::BANK_ACCOUNT_TYPES)],
        ]);

        $seller = $this->seller();

        $data = $request->only(MangopayHelper::BANK_DETAIL_FIELDS);

        $wallet = $this->mangopayWalletRepository
            ->where('seller_id', $seller->id)
            ->first();

        $oldData = $this->mangopayBankDetailsRepository
            ->where('seller_id', $seller->id)
            ->first();

        try {
            if (! $wallet) {
                $name = explode(' ', trim((string) $seller->name), 2);

                $wallet = $this->mangopayHelper->createLegal([
                    'fname' => $name[0] ?? $seller->name,
                    'lname' => $name[1] ?? ($name[0] ?? ''),
                    'email' => $seller->email,
                    'usertype' => 'Seller',
                    'dob' => null,
                    'description' => 'Seller Create Wallet',
                    'seller_id' => $seller->id,
                ]);
            }

            $result = $this->mangopayHelper->saveBankdetail(
                $wallet->mangopay_id,
                $data
            );

            $this->mangopayBankDetailsRepository->create(
                array_merge($data, [
                    'seller_id' => $seller->id,
                    'bank_id' => $result->Id,
                ])
            );

            if ($oldData) {
                $this->mangopayBankDetailsRepository->delete($oldData->id);
            }

            session()->flash('success', trans('mangopay::app.shop.mangopay.bank-details.save-success'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('mangopay.shop.bankdetails');
    }

    /**
     * Display KYC listing page.
     */
    public function kyc(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(KycDatagrid::class)->process();
        }

        return view('mangopay::seller.mangopay.kyc.index');
    }

    /**
     * Display KYC creation page.
     */
    public function createKyc(): View
    {
        $seller = $this->seller();

        return view('mangopay::seller.mangopay.kyc.create', compact('seller'));
    }

    /**
     * Store KYC document.
     */
    public function storeKyc(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'],
            'type' => ['required', 'in:'.implode(',', MangopayHelper::KYC_DOCUMENT_TYPES)],
        ]);

        $seller = $this->seller();

        $wallet = $this->mangopayWalletRepository
            ->where('seller_id', $seller->id)
            ->first();

        if (! $wallet) {
            session()->flash('error', trans('mangopay::app.shop.mangopay.kyc.bank-required'));

            return redirect()->route('mangopay.shop.kyc');
        }

        try {
            $result = $this->mangopayHelper->saveKycDocument(
                $wallet->mangopay_id,
                [
                    'type' => $request->type,
                    'file' => base64_encode(
                        file_get_contents($request->file('file'))
                    ),
                ]
            );

            $this->mangopayKycRepository->create([
                'file' => $request->file('file')->store('kyc-documents/'.$seller->id, 'local'),
                'type' => $request->type,
                'seller_id' => $seller->id,
                'mangopay_file_id' => $result->Id,
                'status' => $result->Status,
            ]);

            session()->flash('success', trans('mangopay::app.shop.mangopay.kyc.save-success'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('mangopay.shop.kyc');
    }

    /**
     * Display transactions listing page.
     */
    public function transactions(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(TransactionDatagrid::class)->process();
        }

        return view('mangopay::seller.mangopay.transactions.index');
    }

    /**
     * Resolve the seller account the signed-in user acts for: the parent seller of a sub-seller.
     */
    protected function seller()
    {
        return seller()->user();
    }
}
