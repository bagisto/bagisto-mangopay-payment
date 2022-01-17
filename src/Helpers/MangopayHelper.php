<?php

namespace Webkul\MangoPay\Helpers;

use Webkul\MangoPay\Repositories\MangopayWalletRepository;
use Cart;


class MangopayHelper
{
    // Sandbox Url
    const SANDBOX = 'https://api.sandbox.mangopay.com';

    // Production Url
    const PRODUCTION = 'https://api.mangopay.com';

    /**
     * MangopayWalletRepository object
     *
     * @var \Webkul\MangoPay\Repositories\MangopayWalletRepository
     */
    protected $mangopayWalletRepository;   
 
    /**
     * Create a new helper instance.
     * @param  \Webkul\MangoPay\Repositories\MangopayWalletRepository  $mangopayWalletRepository
     * @return void
     */
    public function __construct(
        MangopayWalletRepository $mangopayWalletRepository
    ) {
      $this->mangopayWalletRepository = $mangopayWalletRepository;
    }

    /**
     * [createAdminDetail description]
     * @param  [array] $client    [Mangopay Credentials]
     * @param  [array] $wholeData [Admin Details]
     * @return [string]           [Mangopay Id and Wallet Id]
     */
    public function createAdminDetail($wholeData)
    {
        try {
                $userLegal = new \MangoPay\UserLegal();
                $mangopayApi = new \MangoPay\MangoPayApi();

                if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                        $mangopayApi->Config->BaseUrl = self::SANDBOX;
                } else {
                        $mangopayApi->Config->BaseUrl = self::PRODUCTION;
                }

                $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
                $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
                $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
                $userLegal->PersonType = "LEGAL";
                $userLegal->LegalPersonType = "BUSINESS";
                $userLegal->Name = $wholeData['fname'].' '.$wholeData['lname'];
                $userLegal->LegalRepresentativeFirstName = $wholeData['fname'];
                $userLegal->LegalRepresentativeLastName = $wholeData['lname'];
                $userLegal->LegalRepresentativeEmail = $wholeData['email'];
                $userLegal->LegalRepresentativeNationality = "IN";
                $userLegal->LegalRepresentativeCountryOfResidence = "IN";

                if (! isset($wholeData['dob'])) {
                    $userLegal->LegalRepresentativeBirthday = 1404111618;
                } else {
                        $userLegal->LegalRepresentativeBirthday = $wholeData['dob'];
                }

                $userLegal->Email = $wholeData['email'];
                $userLegal->Tag = $wholeData['usertype'];
                $userLegal->Address = null;

                //Send the request to create user
                $result = $mangopayApi->Users->Create($userLegal);
                $wholeData['mangopayid']=$result->Id;

                //Send the request to create user wallet
                $wholeData['walletid']=$this->createAdminWallet($wholeData);

                //Save User Details
                $entityId=$this->saveMangoPayUser($wholeData);
                $result = $entityId.'split'.$wholeData['mangopayid'].'split'.$wholeData['walletid'];
                return $result;

        } catch (\MangoPay\Libraries\ResponseException $e) {
          
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } catch (\MangoPay\Libraries\Exception $e) {
          
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }

     /**
     * [createAdminWallet description]
     * @param  [array] $client    [Config Data]
     * @param  [array] $wholeData [Admin Details]
     * @return [id]            [wallet ID]
     */
    public function createAdminWallet($wholeData)
    {
        try {

            $mangopayApi = new \MangoPay\MangoPayApi();

            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }

            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
            $Wallet = new \MangoPay\Wallet();
            $Wallet->Owners = [$wholeData['mangopayid']];
            $Wallet->Description = 'Admin Wallet Create';
            $Wallet->Currency = core()->getBaseCurrencyCode();
            $Wallet->Tag = $wholeData['usertype'];
            $walletresult = $mangopayApi->Wallets->Create($Wallet);
            return $walletresult->Id;

        } catch (MangoPay\Libraries\ResponseException $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } catch (MangoPay\Libraries\Exception $e) {
           

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }

    /**
     * [saveMangoPayUser Save user details]
     * @param  [Array] $wholedata [user details]
     * @return [boolean]          [Save Data]
     */
    public function saveMangoPayUser($wholedata)
    {
        $wholeData = $this->mangopayWalletRepository->where('admin_id',auth()->guard('admin')->user()->id)->first();

        if( isset($wholeData)) {
            $this->mangopayWalletRepository->whereId($wholeData->id)->delete();
        }

        $result = $this->mangopayWalletRepository->create([
            "admin_id" => auth()->guard('admin')->user()->id,
            "mangopay_id" => $wholedata['mangopayid'],
            "wallet_id"  => $wholedata['walletid']
        ]);       

        return $result->id;
    }

    /**
     * [saveBankdetail Save user Bank details]
     * @param  [int] $id                 [Mangopay entity id]
     * @param  [int] $seller_mangopay_id [Mangopay Id]
     * @param  [array] $wholedata          [User Details]
     * @return [int]                     [bank id]
     */
    public function saveBankdetail($seller_mangopay_id, $wholedata)
    {
        try {

            $BankAccount = new \MangoPay\BankAccount();
            $BankAccount->OwnerAddress = new \MangoPay\Address();
            $mangopayApi = new \MangoPay\MangoPayApi();
            $BankAccount->Type = $wholedata['type'];
            
            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }

            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
            
            if ($wholedata['type']=='IBAN') {
                $BankAccount->Details = new \MangoPay\BankAccountDetailsIBAN();
                $BankAccount->OwnerName = $wholedata['owner_name'];
                $BankAccount->OwnerAddress->AddressLine1 = $wholedata['owner_address'];
                $BankAccount->OwnerAddress->City = $wholedata['owner_city'];
                $BankAccount->OwnerAddress->Region = $wholedata['owner_region'];
                $BankAccount->OwnerAddress->PostalCode = $wholedata['owner_postal_code'];
                $BankAccount->OwnerAddress->Country = $wholedata['country'];
                $BankAccount->Details->IBAN = $wholedata['iban'];
                $BankAccount->Details->BIC = $wholedata['bic'];
            } elseif ($wholedata['type']=='GB') {
                $BankAccount->Details = new \MangoPay\BankAccountDetailsGB();
                $BankAccount->OwnerName = $wholedata['owner_name'];
                $BankAccount->OwnerAddress->AddressLine1 = $wholedata['owner_address'];
                $BankAccount->OwnerAddress->City = $wholedata['owner_city'];
                $BankAccount->OwnerAddress->Region = $wholedata['owner_region'];
                $BankAccount->OwnerAddress->PostalCode = $wholedata['owner_postal_code'];
                $BankAccount->OwnerAddress->Country = $wholedata['country'];
                $BankAccount->Details->AccountNumber = $wholedata['account_number'];
                $BankAccount->Details->SortCode = $wholedata['sortcode'];
            } elseif ($wholedata['type']=='US') {
                $BankAccount->Details = new \MangoPay\BankAccountDetailsUS();
                $BankAccount->OwnerName = $wholedata['owner_name'];
                $BankAccount->OwnerAddress->AddressLine1 = $wholedata['owner_address'];
                $BankAccount->OwnerAddress->City = $wholedata['owner_city'];
                $BankAccount->OwnerAddress->Region = $wholedata['owner_region'];
                $BankAccount->OwnerAddress->PostalCode = $wholedata['owner_postal_code'];
                $BankAccount->OwnerAddress->Country = $wholedata['country'];
                $BankAccount->Details->AccountNumber = $wholedata['account_number'];
                $BankAccount->Details->ABA = $wholedata['aba'];
            } elseif ($wholedata['type']=='CA') {
                $BankAccount->Details = new \MangoPay\BankAccountDetailsCA();
                $BankAccount->OwnerName = $wholedata['owner_name'];
                $BankAccount->OwnerAddress->AddressLine1 = $wholedata['owner_address'];
                $BankAccount->OwnerAddress->City = $wholedata['owner_city'];
                $BankAccount->OwnerAddress->Region = $wholedata['owner_region'];
                $BankAccount->OwnerAddress->PostalCode = $wholedata['owner_postal_code'];
                $BankAccount->OwnerAddress->Country = $wholedata['country'];
                $BankAccount->Details->BankName = $wholedata['bank_name'];
                $BankAccount->Details->InstitutionNumber = $wholedata['institution_number'];
                $BankAccount->Details->BranchCode = $wholedata['branch_code'];
                $BankAccount->Details->AccountNumber = $wholedata['account_number'];
            } elseif ($wholedata['type']=='OTHER') {
                $BankAccount->Details = new \MangoPay\BankAccountDetailsOTHER();
                $BankAccount->OwnerName = $wholedata['owner_name'];
                $BankAccount->OwnerAddress->AddressLine1 = $wholedata['owner_address'];
                $BankAccount->OwnerAddress->City = $wholedata['owner_city'];
                $BankAccount->OwnerAddress->Region = $wholedata['owner_region'];
                $BankAccount->OwnerAddress->PostalCode = $wholedata['owner_postal_code'];
                $BankAccount->OwnerAddress->Country = $wholedata['country'];
                $BankAccount->Details->Country = $wholedata['country'];
                $BankAccount->Details->BIC = $wholedata['bic'];
                $BankAccount->Details->AccountNumber = $wholedata['account_number'];
            }
          
            //Send the request
            $result = $mangopayApi->Users->CreateBankAccount($seller_mangopay_id, $BankAccount);

            return $result;

        } catch (\MangoPay\Libraries\ResponseException $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } 
    }

     /**
     * [createLegal Create Legal User]
     * @param  [Array] $wholeData [User Details]
     * @return [string]            [mangopay or wallet ids]
     */
    public function createLegal($wholeData)
    {
        try {
                $userLegal = new \MangoPay\UserLegal();
                $mangopayApi = new \MangoPay\MangoPayApi();

                if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                    $mangopayApi->Config->BaseUrl = self::SANDBOX;
                } else {
                        $mangopayApi->Config->BaseUrl = self::PRODUCTION;
                }
           
                $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
                $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
                $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
                
                $userLegal->PersonType = "LEGAL";
                $userLegal->LegalPersonType = "BUSINESS";
                $userLegal->Name = $wholeData['fname'].' '.$wholeData['lname'];
                $userLegal->LegalRepresentativeFirstName = $wholeData['fname'];
                $userLegal->LegalRepresentativeLastName = $wholeData['lname'];
                $userLegal->LegalRepresentativeEmail = $wholeData['email'];
                $userLegal->LegalRepresentativeNationality = "IN";
                $userLegal->LegalRepresentativeCountryOfResidence = "IN";

                if (! isset($wholeData['dob'])) {
                    $userLegal->LegalRepresentativeBirthday = 1404111618;
                } else {
                        $userLegal->LegalRepresentativeBirthday = $wholeData['dob'];
                }

                $userLegal->Email = $wholeData['email'];
                $userLegal->Tag = $wholeData['usertype'];

                //Send the request to create user
                $result = $mangopayApi->Users->Create($userLegal);
                $wholeData['mangopayid']=$result->Id;

                //Send the request to create user wallet
                $wholeData['walletid']=$this->createWallet($wholeData);

                //Save User Details
                $result = $this->saveMangoPayUserSeller($wholeData);

                return $result;

        } catch (MangoPay\Libraries\ResponseException $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } catch (MangoPay\Libraries\Exception $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }

      /**
     * [createWallet create user wallet]
     * @param  [array] $wholeData [user details]
     * @return [int]             [wallet id]
     */
    public function createWallet($wholeData)
    {
        try {
            $mangopayApi = new \MangoPay\MangoPayApi();

            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }
       
            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
                
            $Wallet = new \MangoPay\Wallet();
            $Wallet->Owners = [$wholeData['mangopayid']];
            $Wallet->Description = $wholeData['description'];
            $Wallet->Currency = core()->getBaseCurrencyCode();
            $Wallet->Tag = $wholeData['usertype'];
            $walletresult = $mangopayApi->Wallets->Create($Wallet);
            return $walletresult->Id;

        } catch (MangoPay\Libraries\ResponseException $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } catch (MangoPay\Libraries\Exception $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }

    /**
     * [saveMangoPayUser Save user details]
     * @param  [Array] $wholedata [user details]
     * @return [boolean]          [Save Data]
     */
    public function saveMangoPayUserSeller($wholedata)
    {
        $user = auth()->guard('customer')->user();

        $seller = app('Webkul\Marketplace\Repositories\SellerRepository')->where('customer_id',$user->id)->first();

        $wholeData = $this->mangopayWalletRepository->where('seller_id',$seller->id)->first();

        if( isset($wholeData)) {
            $this->mangopayWalletRepository->whereId($wholeData->id)->delete();
        }

        $result = $this->mangopayWalletRepository->create([
            "seller_id" => $seller->id,
            "mangopay_id" => $wholedata['mangopayid'],
            "wallet_id"  => $wholedata['walletid']
        ]);
       
        return $result;
    }

      /**
     * [saveKycDocument description]
     * @param  [int] $mangopayId [Mangopay Id]
     * @param  [array] $kycData  [File Data]
     * @return [Object]          [API response]
     */
    public function saveKycDocument($mangopayId, $kycData)
    {
        try {

            $mangopayApi = new \MangoPay\MangoPayApi();

            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }
       
            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
            
            //Create the KYC document
            $kyc = new \MangoPay\KycDocument();
            $kyc->Type = $kycData['type'];
            $kyc->Tag = "Seller KYC Document";

            $result = $mangopayApi->Users->CreateKycDocument($mangopayId, $kyc);

            $UserId = $result->UserId;
            $KycDocumentId = $result->Id;
            $KycPage = new \MangoPay\KycPage();
            $KycPage->File = isset($kycData['file'])? $kycData['file']:"";

            //Add a page to this KYC Document
            $result2 = $mangopayApi->Users->CreateKycPage($UserId, $KycDocumentId, $KycPage);
            //Submit the KYC document for validation
            $KycDocument = new \MangoPay\KycDocument();
            $KycDocument->Id = $KycDocumentId;
            $KycDocument->Status = "VALIDATION_ASKED";
            $result3 = $mangopayApi->Users->UpdateKycDocument($UserId, $KycDocument);
            return $result3;
        } catch (\MangoPay\Libraries\ResponseException $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }catch (\MangoPay\Libraries\Exception $e) {

            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }


     /**
    * [createNatural Creating Natural User]
    * @param  [Array] $wholeData [customer details]
    * @return [String] [MangopayId &  WalletId]
    */
    public function createNatural($wholeData)
    {
        try {
            $mangopayApi = new \MangoPay\MangoPayApi();
            
            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }
       
            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
                      
            $UserNatural = new \MangoPay\UserNatural();
            if (! isset($wholeData['dob'])) {
                    $UserNatural->Birthday = 1404111618;
            } else {
                    $UserNatural->Birthday = $wholeData['dob'];
            }
            $UserNatural->FirstName = $wholeData['fname'];
            $UserNatural->LastName = $wholeData['lname'];
            $UserNatural->Nationality = $wholeData['country_id'];
            $UserNatural->CountryOfResidence = $wholeData['country_id'];
            $UserNatural->Email = $wholeData['email'];

            //Send the request to create user
            $result = $mangopayApi->Users->Create($UserNatural);
            $wholeData['mangopayid']= $result->Id;

            //Send the request to create user wallet
            $wholeData['walletid']=$this->createWallet($wholeData);

            //Save User Details
            $entityId=$this->saveMangoPayUserCustomer($wholeData);
            $result = $entityId.'split'.$wholeData['mangopayid'].'split'.$wholeData['walletid'];
            return $result;
        } catch (\MangoPay\Libraries\ResponseException $e) {
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        } catch (\MangoPay\Libraries\Exception $e) {
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
        return "";
    }


    /**
     * [saveMangoPayUser Save user details]
     * @param  [Array] $wholedata [user details]
     * @return [boolean]          [Save Data]
     */
    public function saveMangoPayUserCustomer($wholedata)
    {
        $user = auth()->guard('customer')->user();

        $cart = Cart::getCart();

        $result = '';

        if($cart->customer_id == '') {

            $wholeData = $this->mangopayWalletRepository->where('cart_id',$cart->id)->first();

            if( isset($wholeData)) {
                $this->mangopayWalletRepository->whereId($wholeData->id)->delete();
            }

            $result = $this->mangopayWalletRepository->create([
                "cart_id" => $cart->id,
                "mangopay_id" => $wholedata['mangopayid'],
                "wallet_id"  => $wholedata['walletid']
            ]);         

        }else {

            $wholeData = $this->mangopayWalletRepository->where('customer_id',$user->id)->first();

            if( isset($wholeData)) {
                $this->mangopayWalletRepository->whereId($wholeData->id)->delete();
            }

            $result = $this->mangopayWalletRepository->create([
                "customer_id" => $user->id,
                "mangopay_id" => $wholedata['mangopayid'],
                "wallet_id"  => $wholedata['walletid'],
                "cart_id"   => $cart->id
            ]); 
        }      

        return $result;
    }


    /**
     * [makeCardpayment description]
     * @param  [string] $cardType [Card sub Method]
     * @param  [int] $mangopayId [Mangopay Id]
     * @param  [int] $walletId   [Wallet id]
     * @param  [decimal] $amount [Toatl amount]
     * @param  [decimal] $fees   [Admin Comms]
     * @return [Object]          [API response]
     */
    public function makeCardpayment($cardType, $mangopayId, $walletId, $amount, $fees)
    {
        $mangopayApi = new \MangoPay\MangoPayApi();

        if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {

            $mangopayApi->Config->BaseUrl = self::SANDBOX;
        } else {
            $mangopayApi->Config->BaseUrl = self::PRODUCTION;
        }
   
        $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
        $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
        $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
        
        $fees = $fees*100;//amount in cent;
        $amount = $amount*100;
        $culture= core()->getCurrentLocale()->code;   

        try {

            $PayIn = new \MangoPay\PayIn();
            $PayIn->CreditedWalletId = $walletId;
            $PayIn->AuthorId = $mangopayId;
            $PayIn->PaymentType = "CARD";
            $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
            $PayIn->PaymentDetails->CardType = $cardType;
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency =  core()->getBaseCurrencyCode();
            $PayIn->DebitedFunds->Amount = $amount;
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency =  core()->getBaseCurrencyCode();
            $PayIn->Fees->Amount = $fees;
            $PayIn->ExecutionType = "WEB";
            $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
            $PayIn->ExecutionDetails->SecureMode = "DEFAULT";
            $PayIn->ExecutionDetails->ReturnURL = route('mangopay.standard.success');
            $PayIn->ExecutionDetails->Culture = $culture;
            $result2 = $mangopayApi->PayIns->Create($PayIn);

            return $result2;

        } catch (\MangoPay\Libraries\ResponseException $e) {
    
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }


    /**
     * [createTransfer transfer amount buyer wallet to Seller/Admin]
     * @param  [int] $buyerMangopayId    [description]
     * @param  [int] $buyerWalletId      [description]
     * @param  [int] $seller_mangopay_id [description]
     * @param  [int] $seller_wallet_id   [description]
     * @param  [string] $Tag             [description]
     * @param  [decimal] $amount         [description]
     * @param  [decimal] $fees           [description]
     * @return [object]                  [Mangopay Transfer Responsce]
     */
    public function createTransfer(
        $buyerMangopayId,
        $buyerWalletId,
        $seller_mangopay_id,
        $seller_wallet_id,
        $Tag,
        $amount,
        $fees
    ) {

        try {
            $mangopayApi = new \MangoPay\MangoPayApi();
           
            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }
    
            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
        
            $Transfer = new \MangoPay\Transfer();
            $Transfer->AuthorId = $buyerMangopayId;
            $Transfer->CreditedUserId = $seller_mangopay_id;
            $Transfer->DebitedFunds = new \MangoPay\Money();
            $Transfer->DebitedFunds->Currency =  core()->getBaseCurrencyCode();
            $Transfer->DebitedFunds->Amount = $amount*100;//in cents
            $Transfer->Fees = new \MangoPay\Money();
            $Transfer->Fees->Currency =  core()->getBaseCurrencyCode();
            $Transfer->Fees->Amount = $fees*100;
            $Transfer->DebitedWalletID = $buyerWalletId;
            $Transfer->CreditedWalletId = $seller_wallet_id;
            $Transfer->Tag = $Tag;
            $transfer_to_seller_result = $mangopayApi->Transfers->Create($Transfer);
            return $transfer_to_seller_result;
        } catch (\MangoPay\Libraries\ResponseException $e) {
            
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }

      /**
     * [makeRefund Refund Method]
     * @param  [int] $authId  [Buyer Mangopay Id]
     * @param  [decimal] $amount  [Refund Amount]
     * @param  [decimal] $fees    [Fees 0]
     * @param  [int] $payInId [Payin Id]
     * @return [Object]          [description]
     */
    public function makeRefund(
        $authId,
        $amount,
        $fees,
        $payInId
    ) {
        try {
            $mangopayApi = new \MangoPay\MangoPayApi();

            if(core()->getConfigData('sales.paymentmethods.mangopay_standard.sandbox')) {
                $mangopayApi->Config->BaseUrl = self::SANDBOX;
            } else {
                    $mangopayApi->Config->BaseUrl = self::PRODUCTION;
            }
    
            $mangopayApi->Config->ClientId = core()->getConfigData('sales.paymentmethods.mangopay_standard.clientid');
            $mangopayApi->Config->ClientPassword  = core()->getConfigData('sales.paymentmethods.mangopay_standard.passphrase');
            $mangopayApi->Config->TemporaryFolder = storage_path('app/public/mangopay');
        
            $Refund = new \MangoPay\Refund();
            $Refund->AuthorId = $authId;
            $Refund->DebitedFunds = new \MangoPay\Money();
            $Refund->DebitedFunds->Currency = core()->getBaseCurrencyCode();
            $Refund->DebitedFunds->Amount = $amount*100;
            $Refund->Fees = new \MangoPay\Money();
            $Refund->Fees->Currency = core()->getBaseCurrencyCode();
            $Refund->Fees->Amount = $fees*(-100);
            $result = $mangopayApi->PayIns->CreateRefund($payInId, $Refund);
            return $result;

        } catch (MangoPay\Libraries\ResponseException $e) {
            
            session()->flash('warning', __($e->getMessage()));

            return redirect()->back();
        }
    }
    
}
