<?php

namespace Webkul\MangoPay\Helpers;

use Illuminate\Support\Facades\File;
use MangoPay\Address;
use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsCA;
use MangoPay\BankAccountDetailsGB;
use MangoPay\BankAccountDetailsIBAN;
use MangoPay\BankAccountDetailsOTHER;
use MangoPay\BankAccountDetailsUS;
use MangoPay\KycDocument;
use MangoPay\KycPage;
use MangoPay\MangoPayApi;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsWeb;
use MangoPay\PayInPaymentDetailsCard;
use MangoPay\Refund;
use MangoPay\Transfer;
use MangoPay\UserLegal;
use MangoPay\UserNatural;
use MangoPay\Wallet;
use Webkul\Checkout\Facades\Cart;
use Webkul\MangoPay\Repositories\MangopayWalletRepository;

class MangopayHelper
{
    /**
     * MangoPay sandbox API base URL.
     */
    const SANDBOX = 'https://api.sandbox.mangopay.com';

    /**
     * MangoPay production API base URL.
     */
    const PRODUCTION = 'https://api.mangopay.com';

    /**
     * Bank account types MangoPay accepts, one form section each.
     */
    const BANK_ACCOUNT_TYPES = ['IBAN', 'GB', 'US', 'CA', 'OTHER'];

    /**
     * Bank detail fields the admin and seller forms may save.
     */
    const BANK_DETAIL_FIELDS = [
        'type',
        'iban',
        'bic',
        'account_number',
        'sortcode',
        'aba',
        'bank_name',
        'institution_number',
        'branch_code',
        'owner_name',
        'owner_address',
        'owner_city',
        'owner_region',
        'owner_postal_code',
        'country',
    ];

    /**
     * KYC document types a seller may upload.
     */
    const KYC_DOCUMENT_TYPES = [
        'IDENTITY_PROOF',
        'REGISTRATION_PROOF',
        'ARTICLES_OF_ASSOCIATION',
        'SHAREHOLDER_DECLARATION',
        'ADDRESS_PROOF',
    ];

    /**
     * Create a new helper instance.
     */
    public function __construct(
        protected MangopayWalletRepository $mangopayWalletRepository
    ) {}

    /**
     * Create admin legal user + wallet on MangoPay.
     */
    public function createAdminDetail(array $data): string
    {
        $mangopayApi = $this->initApi();

        $userLegal = new UserLegal;
        $userLegal->PersonType = 'LEGAL';
        $userLegal->LegalPersonType = 'BUSINESS';
        $userLegal->Name = ($data['fname'] ?? '').' '.($data['lname'] ?? '');
        $userLegal->LegalRepresentativeFirstName = $data['fname'] ?? '';
        $userLegal->LegalRepresentativeLastName = $data['lname'] ?? '';
        $userLegal->LegalRepresentativeEmail = $data['email'] ?? '';
        $userLegal->LegalRepresentativeNationality = $data['nationality'] ?? $this->getDefaultNationality();
        $userLegal->LegalRepresentativeCountryOfResidence = $data['country_of_residence'] ?? $this->getDefaultNationality();
        $userLegal->LegalRepresentativeBirthday = $data['dob'] ?? 1404111618;
        $userLegal->Email = $data['email'] ?? '';
        $userLegal->Tag = $data['usertype'] ?? 'Administrator';

        $result = $mangopayApi->Users->Create($userLegal);

        $mangopayId = $result->Id;
        $walletId = $this->createAdminWallet([
            'mangopayid' => $mangopayId,
            'usertype' => $data['usertype'] ?? 'Administrator',
        ]);

        $entityId = $this->saveMangoPayUserAdmin([
            'mangopayid' => $mangopayId,
            'walletid' => $walletId,
        ]);

        return $entityId.'split'.$mangopayId.'split'.$walletId;
    }

    /**
     * Create admin wallet on MangoPay.
     */
    public function createAdminWallet(array $data): string
    {
        $mangopayApi = $this->initApi();

        $Wallet = new Wallet;
        $Wallet->Owners = [$data['mangopayid']];
        $Wallet->Description = 'Admin Wallet Create';
        $Wallet->Currency = core()->getBaseCurrencyCode();
        $Wallet->Tag = $data['usertype'] ?? 'Administrator';

        $result = $mangopayApi->Wallets->Create($Wallet);

        return $result->Id;
    }

    /**
     * Save the store's admin wallet locally, recording the admin who created it.
     */
    public function saveMangoPayUserAdmin(array $data): int
    {
        $result = $this->mangopayWalletRepository->create([
            'admin_id' => auth()->guard('admin')->id(),
            'mangopay_id' => $data['mangopayid'],
            'wallet_id' => $data['walletid'],
        ]);

        return $result->id;
    }

    /**
     * Save bank details on MangoPay.
     */
    public function saveBankdetail(string $mangopayId, array $data)
    {
        $mangopayApi = $this->initApi();

        $BankAccount = new BankAccount;
        $BankAccount->OwnerAddress = new Address;
        $BankAccount->Type = $data['type'];

        $BankAccount->OwnerName = $data['owner_name'] ?? '';
        $BankAccount->OwnerAddress->AddressLine1 = $data['owner_address'] ?? '';
        $BankAccount->OwnerAddress->City = $data['owner_city'] ?? '';
        $BankAccount->OwnerAddress->Region = $data['owner_region'] ?? '';
        $BankAccount->OwnerAddress->PostalCode = $data['owner_postal_code'] ?? '';
        $BankAccount->OwnerAddress->Country = $data['country'] ?? '';

        match ($data['type']) {
            'IBAN' => $this->buildBankAccountIBAN($BankAccount, $data),
            'GB' => $this->buildBankAccountGB($BankAccount, $data),
            'US' => $this->buildBankAccountUS($BankAccount, $data),
            'CA' => $this->buildBankAccountCA($BankAccount, $data),
            'OTHER' => $this->buildBankAccountOTHER($BankAccount, $data),
            default => throw new \InvalidArgumentException(trans('mangopay::app.admin.response.unsupported-bank-type', ['type' => $data['type']])),
        };

        return $mangopayApi->Users->CreateBankAccount($mangopayId, $BankAccount);
    }

    /**
     * Create legal user + wallet for sellers.
     */
    public function createLegal(array $data)
    {
        $mangopayApi = $this->initApi();

        $userLegal = new UserLegal;
        $userLegal->PersonType = 'LEGAL';
        $userLegal->LegalPersonType = 'BUSINESS';
        $userLegal->Name = ($data['fname'] ?? '').' '.($data['lname'] ?? '');
        $userLegal->LegalRepresentativeFirstName = $data['fname'] ?? '';
        $userLegal->LegalRepresentativeLastName = $data['lname'] ?? '';
        $userLegal->LegalRepresentativeEmail = $data['email'] ?? '';
        $userLegal->LegalRepresentativeNationality = $data['nationality'] ?? $this->getDefaultNationality();
        $userLegal->LegalRepresentativeCountryOfResidence = $data['country_of_residence'] ?? $this->getDefaultNationality();
        $userLegal->LegalRepresentativeBirthday = $data['dob'] ?? 1404111618;
        $userLegal->Email = $data['email'] ?? '';
        $userLegal->Tag = $data['usertype'] ?? 'Seller';

        $result = $mangopayApi->Users->Create($userLegal);

        $mangopayId = $result->Id;
        $walletId = $this->createWallet([
            'mangopayid' => $mangopayId,
            'description' => $data['description'] ?? 'Seller Wallet',
            'usertype' => $data['usertype'] ?? 'Seller',
        ]);

        return $this->saveMangoPayUserSeller([
            'seller_id' => $data['seller_id'],
            'mangopayid' => $mangopayId,
            'walletid' => $walletId,
        ]);
    }

    /**
     * Create wallet on MangoPay.
     */
    public function createWallet(array $data): string
    {
        $mangopayApi = $this->initApi();

        $Wallet = new Wallet;
        $Wallet->Owners = [$data['mangopayid']];
        $Wallet->Description = $data['description'] ?? 'Wallet';
        $Wallet->Currency = core()->getBaseCurrencyCode();
        $Wallet->Tag = $data['usertype'] ?? 'User';

        $result = $mangopayApi->Wallets->Create($Wallet);

        return $result->Id;
    }

    /**
     * Save seller wallet record locally.
     */
    public function saveMangoPayUserSeller(array $data)
    {
        $existing = $this->mangopayWalletRepository
            ->where('seller_id', $data['seller_id'])
            ->first();

        if ($existing) {
            $this->mangopayWalletRepository->delete($existing->id);
        }

        return $this->mangopayWalletRepository->create([
            'seller_id' => $data['seller_id'],
            'mangopay_id' => $data['mangopayid'],
            'wallet_id' => $data['walletid'],
        ]);
    }

    /**
     * Upload KYC document to MangoPay.
     */
    public function saveKycDocument(string $mangopayId, array $kycData)
    {
        $mangopayApi = $this->initApi();

        $kyc = new KycDocument;
        $kyc->Type = $kycData['type'];
        $kyc->Tag = 'Seller KYC Document';

        $result = $mangopayApi->Users->CreateKycDocument($mangopayId, $kyc);

        $KycPage = new KycPage;
        $KycPage->File = $kycData['file'] ?? '';

        $mangopayApi->Users->CreateKycPage($result->UserId, $result->Id, $KycPage);

        $kycUpdate = new KycDocument;
        $kycUpdate->Id = $result->Id;
        $kycUpdate->Status = 'VALIDATION_ASKED';

        return $mangopayApi->Users->UpdateKycDocument($result->UserId, $kycUpdate);
    }

    /**
     * Create natural user + wallet for customers.
     */
    public function createNatural(array $data): string
    {
        $mangopayApi = $this->initApi();

        $UserNatural = new UserNatural;
        $UserNatural->Birthday = $data['dob'] ?? 1404111618;
        $UserNatural->FirstName = $data['fname'] ?? '';
        $UserNatural->LastName = $data['lname'] ?? '';
        $UserNatural->Nationality = $data['country_id'] ?? $this->getDefaultNationality();
        $UserNatural->CountryOfResidence = $data['country_id'] ?? $this->getDefaultNationality();
        $UserNatural->Email = $data['email'] ?? '';

        $result = $mangopayApi->Users->Create($UserNatural);

        $mangopayId = $result->Id;
        $walletId = $this->createWallet([
            'mangopayid' => $mangopayId,
            'description' => $data['description'] ?? 'Customer Wallet',
            'usertype' => $data['usertype'] ?? 'Customer',
        ]);

        $entityId = $this->saveMangoPayUserCustomer([
            'mangopayid' => $mangopayId,
            'walletid' => $walletId,
        ]);

        return $entityId.'split'.$mangopayId.'split'.$walletId;
    }

    /**
     * Save customer wallet record locally.
     */
    public function saveMangoPayUserCustomer(array $data)
    {
        $user = auth()->guard('customer')->user();
        $cart = Cart::getCart();

        if ($cart->customer_id == '') {
            $existing = $this->mangopayWalletRepository
                ->where('cart_id', $cart->id)
                ->first();

            if ($existing) {
                $this->mangopayWalletRepository->delete($existing->id);
            }

            return $this->mangopayWalletRepository->create([
                'cart_id' => $cart->id,
                'mangopay_id' => $data['mangopayid'],
                'wallet_id' => $data['walletid'],
            ]);
        }

        $existing = $this->mangopayWalletRepository
            ->where('customer_id', $user->id)
            ->first();

        if ($existing) {
            $this->mangopayWalletRepository->delete($existing->id);
        }

        return $this->mangopayWalletRepository->create([
            'customer_id' => $user->id,
            'mangopay_id' => $data['mangopayid'],
            'wallet_id' => $data['walletid'],
            'cart_id' => $cart->id,
        ]);
    }

    /**
     * Create card PayIn on MangoPay, tagged so the MangoPay hook can find what it pays for.
     */
    public function makeCardpayment(string $cardType, string $mangopayId, string $walletId, float $amount, float $fees, ?string $tag = null)
    {
        $mangopayApi = $this->initApi();

        $centsAmount = (int) round($amount * 100);
        $centsFees = (int) round($fees * 100);
        $culture = core()->getCurrentLocale()->code;

        $PayIn = new PayIn;
        $PayIn->CreditedWalletId = $walletId;
        $PayIn->AuthorId = $mangopayId;
        $PayIn->PaymentType = 'CARD';
        $PayIn->PaymentDetails = new PayInPaymentDetailsCard;
        $PayIn->PaymentDetails->CardType = $cardType;
        $PayIn->DebitedFunds = new Money;
        $PayIn->DebitedFunds->Currency = core()->getBaseCurrencyCode();
        $PayIn->DebitedFunds->Amount = $centsAmount;
        $PayIn->Fees = new Money;
        $PayIn->Fees->Currency = core()->getBaseCurrencyCode();
        $PayIn->Fees->Amount = $centsFees;
        $PayIn->ExecutionType = 'WEB';
        $PayIn->ExecutionDetails = new PayInExecutionDetailsWeb;
        $PayIn->ExecutionDetails->SecureMode = 'DEFAULT';
        $PayIn->ExecutionDetails->ReturnURL = route('mangopay.standard.success');
        $PayIn->ExecutionDetails->Culture = $culture;
        $PayIn->Tag = $tag;

        return $mangopayApi->PayIns->Create($PayIn);
    }

    /**
     * Transfer funds between wallets on MangoPay.
     */
    public function createTransfer(
        string $authorId,
        string $debitedWalletId,
        string $creditedUserId,
        string $creditedWalletId,
        string $tag,
        float $amount,
        float $fees
    ) {
        $mangopayApi = $this->initApi();

        $Transfer = new Transfer;
        $Transfer->AuthorId = $authorId;
        $Transfer->CreditedUserId = $creditedUserId;
        $Transfer->DebitedFunds = new Money;
        $Transfer->DebitedFunds->Currency = core()->getBaseCurrencyCode();
        $Transfer->DebitedFunds->Amount = (int) round($amount * 100);
        $Transfer->Fees = new Money;
        $Transfer->Fees->Currency = core()->getBaseCurrencyCode();
        $Transfer->Fees->Amount = (int) round($fees * 100);
        $Transfer->DebitedWalletId = $debitedWalletId;
        $Transfer->CreditedWalletId = $creditedWalletId;
        $Transfer->Tag = $tag;

        return $mangopayApi->Transfers->Create($Transfer);
    }

    /**
     * Refund a PayIn on MangoPay.
     */
    public function makeRefund(string $authorId, float $amount, float $fees, string $payInId)
    {
        $mangopayApi = $this->initApi();

        $Refund = new Refund;
        $Refund->AuthorId = $authorId;
        $Refund->DebitedFunds = new Money;
        $Refund->DebitedFunds->Currency = core()->getBaseCurrencyCode();
        $Refund->DebitedFunds->Amount = (int) round($amount * 100);
        $Refund->Fees = new Money;
        $Refund->Fees->Currency = core()->getBaseCurrencyCode();
        $Refund->Fees->Amount = (int) round($fees * 100);

        return $mangopayApi->PayIns->CreateRefund($payInId, $Refund);
    }

    /**
     * Fetch a PayIn from MangoPay, the only proof that a card payment went through.
     */
    public function getPayIn(string $payInId)
    {
        $mangopayApi = $this->initApi();

        return $mangopayApi->PayIns->Get($payInId);
    }

    /**
     * Initialize MangoPay API with config.
     */
    protected function initApi(): MangoPayApi
    {
        $mangopayApi = new MangoPayApi;

        if (core()->getConfigData('sales.payment_methods.mangopay_standard.sandbox')) {
            $mangopayApi->Config->BaseUrl = self::SANDBOX;
        } else {
            $mangopayApi->Config->BaseUrl = self::PRODUCTION;
        }

        $mangopayApi->Config->ClientId = core()->getConfigData('sales.payment_methods.mangopay_standard.clientid');
        $mangopayApi->Config->ClientPassword = core()->getConfigData('sales.payment_methods.mangopay_standard.passphrase');
        $mangopayApi->Config->TemporaryFolder = $this->temporaryFolder();

        return $mangopayApi;
    }

    /**
     * Get the private folder where the SDK caches its OAuth token, outside the public disk.
     */
    protected function temporaryFolder(): string
    {
        $folder = storage_path('app/mangopay');

        File::ensureDirectoryExists($folder);

        return $folder;
    }

    /**
     * Get default nationality from config, fallback to 'IN'.
     */
    protected function getDefaultNationality(): string
    {
        return core()->getConfigData('sales.shipping.origin.country') ?: 'IN';
    }

    /**
     * Fill IBAN bank account details.
     */
    protected function buildBankAccountIBAN(BankAccount $account, array $data): void
    {
        $account->Details = new BankAccountDetailsIBAN;
        $account->Details->IBAN = $data['iban'] ?? '';
        $account->Details->BIC = $data['bic'] ?? '';
    }

    /**
     * Fill GB bank account details.
     */
    protected function buildBankAccountGB(BankAccount $account, array $data): void
    {
        $account->Details = new BankAccountDetailsGB;
        $account->Details->AccountNumber = $data['account_number'] ?? '';
        $account->Details->SortCode = $data['sortcode'] ?? '';
    }

    /**
     * Fill US bank account details.
     */
    protected function buildBankAccountUS(BankAccount $account, array $data): void
    {
        $account->Details = new BankAccountDetailsUS;
        $account->Details->AccountNumber = $data['account_number'] ?? '';
        $account->Details->ABA = $data['aba'] ?? '';
    }

    /**
     * Fill CA bank account details.
     */
    protected function buildBankAccountCA(BankAccount $account, array $data): void
    {
        $account->Details = new BankAccountDetailsCA;
        $account->Details->BankName = $data['bank_name'] ?? '';
        $account->Details->InstitutionNumber = $data['institution_number'] ?? '';
        $account->Details->BranchCode = $data['branch_code'] ?? '';
        $account->Details->AccountNumber = $data['account_number'] ?? '';
    }

    /**
     * Fill OTHER bank account details.
     */
    protected function buildBankAccountOTHER(BankAccount $account, array $data): void
    {
        $account->Details = new BankAccountDetailsOTHER;
        $account->Details->Country = $data['country'] ?? '';
        $account->Details->BIC = $data['bic'] ?? '';
        $account->Details->AccountNumber = $data['account_number'] ?? '';
    }
}
