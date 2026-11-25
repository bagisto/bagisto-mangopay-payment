<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Webkul\MangoPay\Models\MangopayBankDetails;
use Webkul\MangoPay\Models\MangopayKyc;
use Webkul\MangoPay\Models\MangopayWallet;
use Webkul\MangoPay\Models\Transaction as MangoPayTransfer;
use Webkul\MangoPay\Tests\Doubles\FakeMangoPayApi;
use Webkul\Marketplace\Models\Role;
use Webkul\Marketplace\Models\Seller;
use Webkul\User\Models\Admin;

beforeEach(function () {
    $this->configureMangoPay();

    $this->fakeMangoPay();
});

/**
 * An IBAN bank account payload as the bank details forms post it.
 */
function ibanBankDetails(array $overrides = []): array
{
    return array_merge([
        'type' => 'IBAN',
        'iban' => 'FR7630004000031234567890143',
        'bic' => 'BNPAFRPP',
        'owner_name' => 'Store Owner',
        'owner_address' => '1 Main Street',
        'owner_city' => 'Paris',
        'owner_region' => 'IDF',
        'owner_postal_code' => '75001',
        'country' => 'FR',
    ], $overrides);
}

/**
 * Log in an approved seller of the current channel on the seller guard.
 */
function loginSeller(): Seller
{
    $seller = Seller::factory()->create(['is_approved' => 1]);

    $seller->channels()->sync([core()->getCurrentChannel()->id]);

    auth()->guard('seller')->login($seller);

    return $seller;
}

// ====================================================================
// Admin Wallet And Bank Details
// ====================================================================

it('creates the admin wallet only with a post', function () {
    $this->loginAsAdmin();

    $this->withoutExceptionHandling();

    expect(fn () => $this->get(route('admin.mangopay.create_wallet')))
        ->toThrow(HttpException::class);

    expect(FakeMangoPayApi::called('Users', 'Create'))->toBeFalse();
});

it('creates the admin wallet from the wallet page', function () {
    $admin = $this->loginAsAdmin();

    $this->post(route('admin.mangopay.create_wallet'))
        ->assertRedirect(route('admin.mangopay.wallet'));

    $this->assertDatabaseHas('mangopay_wallets', [
        'admin_id' => $admin->id,
        'wallet_id' => 'wallet-4004',
    ]);
});

it('shows every admin the store wallet and never replaces it', function () {
    $creator = Admin::factory()->create();

    $this->createMangoPayWallet(['admin_id' => $creator->id], 'wallet-store', 'user-store');

    $this->loginAsAdmin();

    $this->get(route('admin.mangopay.wallet'))
        ->assertOk()
        ->assertSee('wallet-store')
        ->assertDontSee(route('admin.mangopay.create_wallet'));

    $this->post(route('admin.mangopay.create_wallet'))
        ->assertRedirect(route('admin.mangopay.wallet'))
        ->assertSessionHas('error', trans('mangopay::app.admin.response.wallet-exists'));

    expect(FakeMangoPayApi::called('Users', 'Create'))->toBeFalse()
        ->and(MangopayWallet::query()->whereNotNull('admin_id')->pluck('wallet_id')->all())->toBe(['wallet-store']);
});

it('registers the store bank account on the store wallet whichever admin saves it', function () {
    $creator = Admin::factory()->create();

    $this->createMangoPayWallet(['admin_id' => $creator->id], 'wallet-store', 'user-store');

    $this->loginAsAdmin();

    $this->post(route('admin.mangopay.save_bank_details.store'), ibanBankDetails())
        ->assertRedirect(route('admin.mangopay.save_bank_details'))
        ->assertSessionHas('success');

    expect(FakeMangoPayApi::firstArgument('Users', 'CreateBankAccount'))->toBe('user-store');
});

it('keeps the store wallet and its records when the admin who created them is deleted', function () {
    $creator = Admin::factory()->create();

    $wallet = $this->createMangoPayWallet(['admin_id' => $creator->id], 'wallet-store', 'user-store');

    $bank = MangopayBankDetails::query()->create(array_merge(ibanBankDetails(), [
        'admin_id' => $creator->id,
        'bank_id' => 'bank-store',
    ]));

    $transfer = MangoPayTransfer::query()->create([
        'transaction_id' => 'transfer-store',
        'amount' => 10,
        'message' => '',
        'status' => 'SUCCEEDED',
        'admin_id' => $creator->id,
    ]);

    $admin = $this->loginAsAdmin();

    $this->deleteJson(route('admin.settings.users.delete', $creator->id))->assertOk();

    expect(Admin::query()->find($creator->id))->toBeNull()
        ->and($wallet->fresh()?->admin_id)->toBe($admin->id)
        ->and($bank->fresh()?->admin_id)->toBe($admin->id)
        ->and($transfer->fresh()?->admin_id)->toBe($admin->id);
});

it('keeps a customer wallet when the cart it was opened from is deleted', function () {
    $cart = $this->createCartForCustomer();

    $wallet = $this->createMangoPayWallet([
        'customer_id' => $cart->customer_id,
        'cart_id' => $cart->id,
    ], 'wallet-customer', 'user-customer');

    $cart->delete();

    expect($wallet->fresh())->not->toBeNull()
        ->and($wallet->fresh()->cart_id)->toBeNull()
        ->and($wallet->fresh()->wallet_id)->toBe('wallet-customer');
});

it('saves admin bank details for the signed-in admin whatever ids are posted', function () {
    $admin = $this->loginAsAdmin();

    $other = Admin::factory()->create();

    $this->createMangoPayWallet(['admin_id' => $admin->id], 'wallet-admin', 'user-admin');

    $seller = Seller::factory()->create();

    $this->post(route('admin.mangopay.save_bank_details.store'), ibanBankDetails([
        'admin_id' => $other->id,
        'seller_id' => $seller->id,
    ]))->assertRedirect(route('admin.mangopay.save_bank_details'));

    $saved = MangopayBankDetails::query()->latest('id')->firstOrFail();

    expect($saved->admin_id)->toBe($admin->id)
        ->and($saved->seller_id)->toBeNull()
        ->and($saved->bank_id)->toBe('bank-2002');
});

it('refuses an unknown bank account type', function () {
    $admin = $this->loginAsAdmin();

    $this->createMangoPayWallet(['admin_id' => $admin->id], 'wallet-admin', 'user-admin');

    $this->post(route('admin.mangopay.save_bank_details.store'), ibanBankDetails(['type' => 'BOGUS']))
        ->assertSessionHasErrors('type');

    expect(FakeMangoPayApi::called('Users', 'CreateBankAccount'))->toBeFalse();
});

// ====================================================================
// Seller Onboarding
// ====================================================================

it('saves seller bank details for the signed-in seller only', function () {
    $this->setConfig('marketplace.general.general.status', '1');

    $seller = loginSeller();

    $admin = $this->loginAsAdmin();

    $this->createMangoPayWallet(['seller_id' => $seller->id], 'wallet-seller', 'user-seller');

    $this->post(route('mangopay.shop.bankdetails.store'), ibanBankDetails([
        'admin_id' => $admin->id,
        'seller_id' => $seller->id + 1000,
    ]))->assertRedirect(route('mangopay.shop.bankdetails'));

    $saved = MangopayBankDetails::query()->where('seller_id', $seller->id)->firstOrFail();

    expect($saved->admin_id)->toBeNull()
        ->and(FakeMangoPayApi::firstArgument('Users', 'CreateBankAccount'))->toBe('user-seller');
});

it('saves a sub-seller\'s bank details on the seller account they work for', function () {
    $this->setConfig('marketplace.general.general.status', '1');

    $parent = Seller::factory()->create(['is_approved' => 1]);

    $role = Role::query()->create([
        'name' => 'Payouts',
        'description' => 'Payouts',
        'permission_type' => 'custom',
        'permissions' => ['mangopay', 'mangopay.bankdetails'],
        'marketplace_seller_id' => $parent->id,
    ]);

    $subSeller = Seller::factory()->create([
        'is_approved' => 1,
        'parent_id' => $parent->id,
        'marketplace_role_id' => $role->id,
    ]);

    $subSeller->channels()->sync([core()->getCurrentChannel()->id]);

    auth()->guard('seller')->login($subSeller);

    $this->createMangoPayWallet(['seller_id' => $parent->id], 'wallet-parent', 'user-parent');

    $this->post(route('mangopay.shop.bankdetails.store'), ibanBankDetails())
        ->assertRedirect(route('mangopay.shop.bankdetails'));

    expect(MangopayBankDetails::query()->where('seller_id', $parent->id)->exists())->toBeTrue()
        ->and(MangopayBankDetails::query()->where('seller_id', $subSeller->id)->exists())->toBeFalse()
        ->and(FakeMangoPayApi::firstArgument('Users', 'CreateBankAccount'))->toBe('user-parent');
});

it('stores a seller kyc document on the private disk', function () {
    Storage::fake('local');

    $this->setConfig('marketplace.general.general.status', '1');

    $seller = loginSeller();

    $this->createMangoPayWallet(['seller_id' => $seller->id], 'wallet-seller', 'user-seller');

    $this->post(route('mangopay.shop.kyc.store'), [
        'type' => 'IDENTITY_PROOF',
        'file' => UploadedFile::fake()->create('passport.pdf', 100, 'application/pdf'),
    ])->assertRedirect(route('mangopay.shop.kyc'));

    $kyc = MangopayKyc::query()->where('seller_id', $seller->id)->firstOrFail();

    expect($kyc->file)->toStartWith('kyc-documents/'.$seller->id.'/');

    Storage::disk('local')->assertExists($kyc->file);
});

it('refuses a kyc document of an unknown type or a non-document file', function (array $payload, string $field) {
    $this->setConfig('marketplace.general.general.status', '1');

    $seller = loginSeller();

    $this->createMangoPayWallet(['seller_id' => $seller->id], 'wallet-seller', 'user-seller');

    $this->post(route('mangopay.shop.kyc.store'), $payload)->assertSessionHasErrors($field);

    expect(FakeMangoPayApi::called('Users', 'CreateKycDocument'))->toBeFalse();
})->with([
    'unknown type' => [
        fn () => [
            'type' => 'SELFIE',
            'file' => UploadedFile::fake()->create('passport.pdf', 100, 'application/pdf'),
        ],
        'type',
    ],

    'script file' => [
        fn () => [
            'type' => 'IDENTITY_PROOF',
            'file' => UploadedFile::fake()->create('shell.php', 1, 'application/x-php'),
        ],
        'file',
    ],
]);
