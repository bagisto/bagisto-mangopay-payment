<?php

use Webkul\MangoPay\Payment\Standard;
use Webkul\Payment\Facades\Payment;

it('offers mangopay at checkout once it is active and configured', function () {
    // Arrange
    $this->configureMangoPay();

    // Act
    $codes = collect(Payment::getPaymentMethods())->pluck('method')->all();

    // Assert
    expect($codes)->toContain('mangopay_standard');
});

it('withdraws when the payment method is switched off', function () {
    // Arrange
    $this->configureMangoPay(['active' => '0']);

    // Act & Assert
    expect((new Standard)->isAvailable())->toBeFalse()
        ->and(collect(Payment::getPaymentMethods())->pluck('method')->all())
        ->not->toContain('mangopay_standard');
});

it('withdraws when the client id is missing', function () {
    // Arrange
    $this->configureMangoPay(['clientid' => '']);

    // Act & Assert
    expect((new Standard)->isAvailable())->toBeFalse();
});

it('withdraws when the passphrase is missing', function () {
    // Arrange
    $this->configureMangoPay(['passphrase' => '']);

    // Act & Assert
    expect((new Standard)->isAvailable())->toBeFalse();
});

it('sends the customer to the mangopay redirect route', function () {
    // Arrange
    $this->configureMangoPay();

    // Act & Assert
    expect((new Standard)->getRedirectUrl())->toBe(route('mangopay.standard.redirect'));
});

it('keeps the other payment methods available whatever mangopay does', function () {
    // Arrange
    $this->configureMangoPay(['active' => '0']);

    // Act
    $codes = collect(Payment::getPaymentMethods())->pluck('method')->all();

    // Assert - checkout still has options, mangopay simply is not one of them
    expect($codes)->not->toBeEmpty()
        ->not->toContain('mangopay_standard');
});

it('does not disturb the other payment methods when it is available', function () {
    // Arrange
    $this->configureMangoPay(['active' => '0']);

    $without = collect(Payment::getPaymentMethods())->pluck('method')->sort()->values()->all();

    $this->configureMangoPay(['active' => '1']);

    // Act
    $with = collect(Payment::getPaymentMethods())->pluck('method')->sort()->values()->all();

    // Assert - the only difference is mangopay itself
    expect(array_values(array_diff($with, $without)))->toBe(['mangopay_standard'])
        ->and(array_diff($without, $with))->toBeEmpty();
});
