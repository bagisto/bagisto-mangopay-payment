<?php

use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Webkul\MangoPay\Helpers\ReleaseAmount;
use Webkul\MangoPay\Models\EscrowedAmount;
use Webkul\MangoPay\Models\MangopayWallet;
use Webkul\MangoPay\Models\Transaction as MangoPayTransfer;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Marketplace\Models\Seller;
use Webkul\Marketplace\Models\Transaction as SellerPayout;
use Webkul\Marketplace\Repositories\TransactionRepository;

beforeEach(function () {
    $this->configureMangoPay();

    $this->fakeMangoPay();

    $this->admin = $this->loginAsAdmin();

    $this->createMangoPayWallet(['admin_id' => $this->admin->id], 'wallet-admin', 'user-admin');

    $this->sellerA = Seller::factory()->create(['is_approved' => 1]);

    $this->sellerB = Seller::factory()->create(['is_approved' => 1]);

    $this->createMangoPayWallet(['seller_id' => $this->sellerA->id], 'wallet-seller-a', 'user-seller-a');
});

/**
 * The amount, in cents, of every transfer credited to the given wallet.
 */
function transfersTo(string $walletId): array
{
    return collect(FakeMangoPayApi::callsTo('Transfers', 'Create'))
        ->filter(fn ($call) => $call['argument']->CreditedWalletId === $walletId)
        ->map(fn ($call) => $call['argument']->DebitedFunds->Amount)
        ->values()
        ->all();
}

// ====================================================================
// Shared Orders
// ====================================================================

it('pays each seller of a shared order once and the admin the rest', function () {
    $escrow = $this->createSharedEscrow(300, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 90,
            'seller_total_invoiced' => 90,
        ], [
            'seller' => $this->sellerB,
            'base_seller_total_invoiced' => 45,
            'seller_total_invoiced' => 45,
        ],
    ]);

    app(ReleaseAmount::class)->execute([
        'id' => $escrow->id,
        'message' => 'Released',
    ]);

    $walletB = MangopayWallet::query()->where('seller_id', $this->sellerB->id)->firstOrFail();

    expect(transfersTo('wallet-seller-a'))->toBe([9000])
        ->and(transfersTo($walletB->wallet_id))->toBe([4500])
        ->and(transfersTo('wallet-admin'))->toBe([16500])
        ->and($escrow->fresh()->status)->toBe('1');

    expect(SellerPayout::query()->where('method', ReleaseAmount::PAYOUT_METHOD)->pluck('base_total')->map(fn ($v) => (float) $v)->sort()->values()->all())
        ->toBe([45.0, 90.0]);
});

it('pays the admin share into the store wallet whichever admin releases it', function () {
    $escrow = $this->createSharedEscrow(100, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 60,
        ],
    ]);

    $this->loginAsAdmin();

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(transfersTo('wallet-admin'))->toBe([4000])
        ->and($escrow->fresh()->status)->toBe('1');
});

it('debits every transfer from the wallet the order was paid from', function () {
    $escrow = $this->createSharedEscrow(100, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 60,
        ],
    ]);

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(collect(FakeMangoPayApi::callsTo('Transfers', 'Create'))->pluck('argument.DebitedWalletId')->unique()->all())
        ->toBe(['wallet-buyer']);
});

it('keeps a payout the admin already made through marketplace out of the seller transfer', function () {
    $escrow = $this->createSharedEscrow(300, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 90,
        ],
    ]);

    app(TransactionRepository::class)->paySeller([
        'order_id' => $escrow->order_id,
        'marketplace_seller_id' => $this->sellerA->id,
        'amount' => 40,
        'comment' => 'Paid by hand',
    ]);

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(transfersTo('wallet-seller-a'))->toBe([5000])
        ->and(transfersTo('wallet-admin'))->toBe([25000]);
});

it('deducts the seller share of a refund from their payout', function () {
    $escrow = $this->createSharedEscrow(300, [[
        'seller' => $this->sellerA,
        'base_seller_total_invoiced' => 90,
        'base_sub_total_refunded' => 20,
        'base_tax_amount_refunded' => 2,
        'commission_percentage' => 10,
    ]], ['base_grand_total_refunded' => 22]);

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(transfersTo('wallet-seller-a'))->toBe([7000])
        ->and(transfersTo('wallet-admin'))->toBe([20800]);
});

it('leaves the payout of an unapproved seller with the admin', function () {
    $this->sellerB->update(['is_approved' => 0]);

    $escrow = $this->createSharedEscrow(200, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 90,
        ], [
            'seller' => $this->sellerB,
            'base_seller_total_invoiced' => 45,
        ],
    ]);

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(transfersTo('wallet-seller-a'))->toBe([9000])
        ->and(transfersTo('wallet-admin'))->toBe([11000])
        ->and(MangopayWallet::query()->where('seller_id', $this->sellerB->id)->exists())->toBeFalse();
});

// ====================================================================
// Failures And Retries
// ====================================================================

it('moves no money when the escrow cannot cover the seller payouts', function () {
    $escrow = $this->createSharedEscrow(100, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 90,
        ],
    ], ['base_grand_total_refunded' => 50]);

    expect(fn () => app(ReleaseAmount::class)->execute(['id' => $escrow->id]))
        ->toThrow(Exception::class, trans('mangopay::app.admin.response.insufficient-escrow'));

    expect(FakeMangoPayApi::called('Transfers', 'Create'))->toBeFalse()
        ->and($escrow->fresh()->status)->toBe('0');
});

it('resumes a failed release without paying a seller twice', function () {
    $escrow = $this->createSharedEscrow(300, [
        [
            'seller' => $this->sellerA,
            'base_seller_total_invoiced' => 90,
        ],
    ]);

    FakeMangoPayApi::$responses['Transfers.Create'] = function ($transfer) {
        $response = new stdClass;

        $response->Id = 'transfer-'.$transfer->CreditedWalletId;
        $response->Status = $transfer->CreditedWalletId === 'wallet-admin' ? 'FAILED' : 'SUCCEEDED';
        $response->ResultMessage = 'Insufficient wallet balance';

        return $response;
    };

    expect(fn () => app(ReleaseAmount::class)->execute(['id' => $escrow->id]))
        ->toThrow(Exception::class, 'Insufficient wallet balance');

    expect($escrow->fresh()->status)->toBe('0');

    FakeMangoPayApi::reset();

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(transfersTo('wallet-seller-a'))->toBe([])
        ->and(transfersTo('wallet-admin'))->toBe([21000])
        ->and($escrow->fresh()->status)->toBe('1')
        ->and(MangoPayTransfer::query()->where('seller_id', $this->sellerA->id)->count())->toBe(1);
});

it('refuses to release an escrow twice', function () {
    $escrow = $this->createSharedEscrow(100, []);

    app(ReleaseAmount::class)->execute(['id' => $escrow->id]);

    expect(fn () => app(ReleaseAmount::class)->execute(['id' => $escrow->id]))
        ->toThrow(Exception::class, trans('mangopay::app.admin.response.already-released'));
});

it('refuses a release while another one for the same escrow runs', function () {
    $escrow = $this->createSharedEscrow(100, []);

    $lock = Cache::lock('mangopay-escrow-'.$escrow->id, 120);

    $lock->get();

    expect(fn () => app(ReleaseAmount::class)->execute(['id' => $escrow->id]))
        ->toThrow(Exception::class, trans('mangopay::app.admin.response.request-in-progress'));

    $lock->release();

    expect(FakeMangoPayApi::called('Transfers', 'Create'))->toBeFalse();
});

// ====================================================================
// Release Route
// ====================================================================

it('releases the escrow from the admin escrow grid', function () {
    $escrow = $this->createSharedEscrow(100, []);

    $this->post(route('admin.mangopay.release_amount', $escrow->id))
        ->assertRedirect(route('admin.mangopay.amount'))
        ->assertSessionHas('success');

    expect(EscrowedAmount::query()->find($escrow->id)->status)->toBe('1');
});

it('does not match the release route for a non-numeric id', function () {
    $this->withoutExceptionHandling();

    expect(fn () => $this->post(config('app.admin_url').'/mangopay/release-amount/abc'))
        ->toThrow(HttpException::class);
});
