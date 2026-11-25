<?php

use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Marketplace\Models\Seller;

it('registers a seller as a legal user, opens a wallet and stores both ids', function () {
    // Arrange
    $this->configureMangoPay();

    $seller = Seller::factory()->create(['is_approved' => 1]);

    // Act
    $this->mangopay()->createLegal([
        'seller_id' => $seller->id,
        'fname' => 'Vaibhav', 'lname' => 'Rathaur', 'email' => 'seller@example.test',
        'dob' => '1990-05-20', 'nationality' => 'IN', 'countryofresidence' => 'IN',
    ]);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('Users', 'Create');

    expect($sent->PersonType)->toBe('LEGAL')
        ->and($sent->LegalRepresentativeFirstName)->toBe('Vaibhav')
        ->and($sent->LegalRepresentativeLastName)->toBe('Rathaur');

    $this->assertDatabaseHas('mangopay_wallets', [
        'seller_id' => $seller->id,
        'mangopay_id' => 'user-1001',
        'wallet_id' => 'wallet-4004',
    ]);
});

it('registers a customer as a natural user and returns entity, user and wallet ids', function () {
    // Arrange
    $this->configureMangoPay();

    $this->createCartForCustomer();

    // Act
    $result = $this->mangopay()->createNatural([
        'fname' => 'Asha', 'lname' => 'Kumar', 'email' => 'buyer@example.test',
        'dob' => '1992-01-10', 'nationality' => 'IN', 'countryofresidence' => 'IN',
    ]);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('Users', 'Create');

    expect($sent->PersonType)->toBe('NATURAL')
        ->and($sent->FirstName)->toBe('Asha')
        ->and($sent->LastName)->toBe('Kumar')
        ->and(explode('split', $result))->toHaveCount(3)
        ->and(explode('split', $result)[1])->toBe('user-1001')
        ->and(explode('split', $result)[2])->toBe('wallet-4004');
});

it('opens a wallet owned by the given mangopay user', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $id = $this->mangopay()->createWallet([
        'mangopayid' => 'user-1001', 'description' => 'Seller wallet', 'usertype' => 'seller',
    ]);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('Wallets', 'Create');

    expect($id)->toBe('wallet-4004')
        ->and($sent->Owners)->toBe(['user-1001'])
        ->and($sent->Description)->toBe('Seller wallet')
        ->and($sent->Currency)->toBe(core()->getBaseCurrencyCode());
});

it('converts the payment amount and fee to cents, as the api expects', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $this->mangopay()->makeCardpayment('CB_VISA_MASTERCARD', 'user-1001', 'wallet-4004', 149.99, 12.34);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('PayIns', 'Create');

    expect($sent->DebitedFunds->Amount)->toBe(14999)
        ->and($sent->Fees->Amount)->toBe(1234)
        ->and($sent->DebitedFunds->Currency)->toBe(core()->getBaseCurrencyCode());
});

it('rounds half-cent amounts rather than truncating them', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $this->mangopay()->makeCardpayment('CB_VISA_MASTERCARD', 'user-1001', 'wallet-4004', 0.015, 0.005);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('PayIns', 'Create');

    expect($sent->DebitedFunds->Amount)->toBe(2)
        ->and($sent->Fees->Amount)->toBe(1);
});

it('sends the card payment as a web payin that returns to the success route', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $this->mangopay()->makeCardpayment('CB_VISA_MASTERCARD', 'user-1001', 'wallet-4004', 50.00, 5.00);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('PayIns', 'Create');

    expect($sent->PaymentType)->toBe('CARD')
        ->and($sent->ExecutionType)->toBe('WEB')
        ->and($sent->CreditedWalletId)->toBe('wallet-4004')
        ->and($sent->AuthorId)->toBe('user-1001')
        ->and($sent->PaymentDetails->CardType)->toBe('CB_VISA_MASTERCARD')
        ->and($sent->ExecutionDetails->ReturnURL)->toBe(route('mangopay.standard.success'));
});

it('transfers funds between two wallets in cents', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $this->mangopay()->createTransfer('user-1001', 'wallet-4004', 'user-2002', 'wallet-5005', 'order-42', 80.50, 3.25);

    // Assert
    $sent = FakeMangoPayApi::firstArgument('Transfers', 'Create');

    expect($sent->DebitedFunds->Amount)->toBe(8050)
        ->and($sent->Fees->Amount)->toBe(325)
        ->and($sent->DebitedWalletId)->toBe('wallet-4004')
        ->and($sent->CreditedWalletId)->toBe('wallet-5005');
});

it('refunds against the original payin', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $this->mangopay()->makeRefund('user-1001', 25.00, 1.00, 'payin-5005');

    // Assert
    expect(FakeMangoPayApi::called('PayIns', 'CreateRefund'))->toBeTrue();

    $call = collect(FakeMangoPayApi::$calls)->firstWhere('method', 'CreateRefund');

    expect($call['service'])->toBe('PayIns');
});

it('points at the sandbox host while sandbox mode is on', function () {
    // Arrange
    $this->configureMangoPay(['sandbox' => '1']);

    // Act & Assert
    expect(core()->getConfigData('sales.payment_methods.mangopay_standard.sandbox'))->toBe('1');
});

it('never leaks the client credentials into an exception message', function () {
    // Arrange
    $this->configureMangoPay([
        'clientid' => 'super-secret-id',
        'passphrase' => 'super-secret-pass',
    ]);

    $mangopay = $this->mangopay();

    // the fake is reset when the helper is built, so arm the failure after that
    FakeMangoPayApi::$throw = new Exception('MangoPay responded 401 Unauthorized');

    // Act
    $thrown = null;

    try {
        $mangopay->createWallet(['mangopayid' => 'user-1001']);
    } catch (Throwable $e) {
        $thrown = $e;
    }

    // Assert
    expect($thrown)->not->toBeNull()
        ->and($thrown->getMessage())->not->toContain('super-secret-id')
        ->and($thrown->getMessage())->not->toContain('super-secret-pass');
});

it('lets a gateway failure surface rather than returning a bad wallet id', function () {
    // Arrange
    $this->configureMangoPay();

    $mangopay = $this->mangopay();

    FakeMangoPayApi::$throw = new Exception('MangoPay responded 500');

    // Act & Assert
    expect(fn () => $mangopay->createWallet(['mangopayid' => 'user-1001']))
        ->toThrow(Exception::class);
});
