# AGENTS.md — Marketplace MangoPay Payment

Bagisto Marketplace **MangoPay payment gateway** (`packages/Webkul/MangoPay`): customers pay by card
through MangoPay, buyer funds are held in a MangoPay wallet (escrow), sellers onboard with bank
details and KYC, and the admin releases escrowed funds as seller payouts and issues refunds — all
through the MangoPay API.

This file is the single source of instructions for every coding agent working on this repository.
`CLAUDE.md` only imports it.

## Skills — load the relevant one before writing code, not after

The conventions are kept as skills under `.claude/skills/<name>/SKILL.md` (in the Bagisto app this
module is developed in). If your harness has no skill loader, read those files directly — they are
plain markdown.

| Working on | Load |
|---|---|
| Any upgrade or normalisation of this repository (version bump, docs, changelog, commit/verify/push) | `marketplace-module-upgrade` |
| Any PHP or Blade | `bagisto-coding-standards` |
| Providers, models, repositories, routes, controllers, ACL, menus, config | `bagisto-package-development` |
| The `mangopay_standard` payment method (`src/Payment`, `Config/paymentmethods.php`, `Config/system.php`, the checkout/refund flow) | `bagisto-payment-method-development` |
| The admin and seller DataGrids (`src/DataGrids`) | `bagisto-datagrid-development` |
| Pest tests (`tests/Feature`, `tests/Unit`) | `bagisto-pest-testing` |
| Playwright end-to-end tests (`tests/e2e-pw`) | `bagisto-playwright-testing` |
| Branching, commits, CHANGELOG | `bagisto-git-workflow` |
| Before calling any change done | `bagisto-change-verification` |

## Identity

- Package / namespace: `Webkul\MangoPay`; Composer package `bagisto/marketplace-mangopay-payment`.
- Providers: `Providers\MangoPayServiceProvider` (main), `Providers\ModuleServiceProvider` (Concord;
  registered from `MangoPayServiceProvider::boot()` via `$this->app->register(...)`, **not** from the
  app `config/concord.php`).
- Translation and view namespace: `mangopay`.
- Payment method code / class: `mangopay_standard` / `Webkul\MangoPay\Payment\Standard` (extends
  `Payment\Mangopay`, which extends `Webkul\Payment\Payment\Payment`).
- Middleware alias: `mangopay` (`Http\Middleware\Mangopay`) — `abort(404)` unless
  `sales.payment_methods.mangopay_standard.active`.
- Install command: `mangopay:install` (no flags).
- Tables: `mangopay_wallets`, `mangopay_bank_details`, `mangopay_kyc`, `mangopay_escrowed_amount`,
  `mangopay_transaction_details`.
- Third-party SDK: MangoPay PHP SDK (`MangoPay\` namespace). The package's own `composer.json`
  `require` is empty — the SDK is added to the host app on install as `mangopay4/php-sdk:^4.0`
  (README and CI). `mangopay/php-sdk-v2` is the abandoned name of the same SDK; never document it.
- Versions: module v2.5.0.0 on branch `stable/2.5`, for Bagisto v2.5.0 (Laravel 13, PHP 8.4) and
  Marketplace v2.5.0.x, on MySQL 8.0, MariaDB 10.11 or PostgreSQL 16. Pure backend — no asset build.

## Repository Map

```
├── AGENTS.md / CLAUDE.md / README.md / CHANGELOG.md / UPGRADE.md
├── .gitlab-ci.yml                      # 2 isolated stages: Pest, then Playwright
└── packages/Webkul/MangoPay/
    ├── composer.json                   # require {} — SDK added on install; NO extra.laravel.providers
    ├── tests/                          # MangoPayTestCase, Concerns/, Doubles/, Feature/, Unit/, e2e-pw/
    └── src/
        ├── Payment/{Mangopay,Standard}.php     # method `mangopay_standard`
        ├── Config/
        │   ├── paymentmethods.php      # `mangopay_standard` -> Payment\Standard
        │   ├── system.php              # admin settings form (merged into `core`)
        │   ├── admin-menu.php / acl.php        # admin area (gated on the method being active)
        │   └── shop-menu.php, seller/acl.php   # seller area (gated on the marketplace being on)
        ├── Console/Commands/Install.php        # mangopay:install
        ├── Contracts/ + Models/        # EscrowedAmount, MangopayBankDetails, MangopayKyc, MangopayWallet,
        │                               #   Transaction, each with a *Proxy (Concord)
        ├── Database/Migrations/        # 5 tables
        ├── Database/Seeders/           # DatabaseSeeder, MangoPayConfiguration
        ├── DataGrids/Admin/            # EscrowedAmountDataGrid, TransactionDataGrid
        ├── DataGrids/Shop/             # KycDatagrid, TransactionDatagrid (seller)
        ├── Helpers/{MangopayHelper,PaymentProcessHelper,ReleaseAmount}.php
        ├── Http/Controllers/Admin/     # Amount, BankDetails, Refund, Transaction, Wallet
        ├── Http/Controllers/Shop/      # MangoPayController (seller), MangoPayStandardController (buyer)
        ├── Http/Middleware/Mangopay.php
        ├── Providers/
        ├── Repositories/               # EscrowedAmount, MangopayBankDetails, MangopayKyc, MangopayTransferAmount, MangopayWallet
        ├── Resources/{assets,lang,views}/   # 22 locales
        ├── Routes/{admin,shop}-routes.php
        └── Templates/on-boarding.php
```

## Do Not Edit

- `vendor/`, `node_modules/` (including `tests/e2e-pw/node_modules`), lock files.

## Install & Load Order

- The provider is registered **manually in the app `bootstrap/providers.php`, after
  `MarketplaceServiceProvider`** (README step 5). It is NOT auto-discovered — `composer.json` has no
  `extra.laravel.providers`; do not add one.
- It depends on Core and Marketplace: `boot()` reads
  `core()->getConfigData('marketplace.general.general.status')` and merges into
  `marketplace_menu.seller` / `marketplace_acl`, and `ReleaseAmount` uses Marketplace's
  `OrderRepository` (seller orders), `SellerRepository` and `TransactionRepository::paySeller()`.
  `mergeConfig()` is guarded on `Schema::hasTable('core_config')`, so a fresh install does not die
  before the tables exist.
- Install wiring (mirrored by CI): add the PSR-4 line
  `"Webkul\\MangoPay\\": "packages/Webkul/MangoPay/src"`, `composer require` the MangoPay SDK,
  register the provider, then `php artisan mangopay:install`. The installer migrates with
  `realpath(...)` + `--realpath` (so it works under a symlinked path install), seeds the default
  payment-method configuration (`Database\Seeders\DatabaseSeeder` → `MangoPayConfiguration`), runs
  `vendor:publish --force` for the provider and `optimize:clear`.

## Config Merging (conditional — know the gates)

`registerConfig()` merges `Config/paymentmethods.php` into `payment_methods` and `Config/system.php`
into `core` (the admin payment-method settings form).

`mergeConfig()` only runs when `core_config` exists and the marketplace is enabled, then:

- **Always (marketplace on):** merges `Config/shop-menu.php` into `marketplace_menu.seller` and
  `Config/seller/acl.php` into `marketplace_acl`, so a seller can register bank details / KYC
  **before** the gateway is switched on (and never hits a 404). The seller menu must stay paired with
  the seller ACL — an ungated `marketplace_menu.seller` key is visible to every seller, because
  `seller()->hasPermission()` allows any key absent from `marketplace_acl`.
- **Only when `mangopay_standard.active`:** merges `Config/admin-menu.php` into `menu.admin` and
  `Config/acl.php` into `acl` — the admin escrow/wallet area (ACL root `marketplace.mangopay`).

Config keys all live under `sales.payment_methods.mangopay_standard.*`: `active`, `title`,
`description`, `image`, `clientid`, `passphrase`, `sandbox`, `sort`. `Standard::isAvailable()`
additionally requires `clientid` and `passphrase` to be set.

## Routes

- **Admin** (`admin-routes.php`, middleware `web, admin, mangopay`, prefix
  `config('app.admin_url').'/mangopay'`): wallets (`admin.mangopay.wallet`,
  `admin.mangopay.create_wallet` — POST), bank details (`admin.mangopay.save_bank_details[.store]`),
  transactions (`admin.mangopay.transaction`, `admin.mangopay.release_amount` — POST), transfer amount
  (`admin.mangopay.amount`), refunds (`admin.mangopay.refund.create|store`). Every admin route is
  mapped in `Config/acl.php` (refunds under `marketplace.mangopay.refund`), merged into `acl` whatever the
  settings, as `Config/seller/acl.php` is into `marketplace_acl` (every seller route mapped): core v2.5's Bouncer
  refuses an unmapped admin route for every role whose permission type is not **All**, so a new admin
  route needs an ACL entry. Integer route ids carry `whereNumber()`. Never hardcode `admin` — the
  admin URL comes from `APP_ADMIN_URL`.
- **Seller** (`shop-routes.php`, middleware `web, marketplace, theme, seller, seller.locale`, prefix
  `seller/mangopay`): `mangopay.shop.bankdetails[.store]`, `mangopay.shop.kyc[.create|.store]`,
  `mangopay.shop.transactions`. Gated on the marketplace being on, **not** on the payment method
  (deliberate — see above).
- **Buyer checkout** (`shop-routes.php`, middleware `web, shop, mangopay`, prefix
  `mangopay/standard`): `mangopay.standard.redirect`, `.success`, `.cancel`, `.redirect_mangopay`.
- **MangoPay hooks** (`GET mangopay/webhook`, `mangopay.webhook`, public by design, no CSRF exemption
  needed): `MangoPayWebhookController` acts on `PAYIN_NORMAL_SUCCEEDED` only, reads the PayIn back
  from the API, finds the cart from the PayIn `Tag` (`PaymentProcessHelper::cartIdFromTag()`) and
  places the order through the same `Helpers/OrderPlacement` as the return page. Nothing in the
  request is trusted.
- Route names are snake_case, as in core v2.5.

## Behaviour

- **Checkout (buyer):** `PaymentProcessHelper` creates or reuses a MangoPay natural user and wallet for
  the buyer and runs a web card PayIn for the cart's **base** grand total in the base currency (its id
  is kept in the session as `payin_id`); buyer funds land in the buyer's MangoPay wallet (escrow). The
  return (`success`) is never proof of payment: it only accepts the PayIn the session started
  (`transactionId` = `payin_id`) and hands it to `Helpers/OrderPlacement::place()`, which the hook
  controller uses too. `OrderPlacement` re-reads the PayIn from the API and requires `SUCCEEDED`,
  credited to the buyer's wallet, for the active cart's base grand total in the base currency; a
  PayIn places one order at most (cache lock + escrow lookup by `payin_id`). A succeeded PayIn that
  cannot become an order (cart changed or inactive, order creation throws, e.g.
  `InsufficientInventoryException`) is refunded to the card — the store never keeps money without an
  order.
- **Store admin wallet:** the store has one admin wallet and one admin bank account
  (`MangopayWalletRepository::adminWallet()` / `MangopayBankDetailsRepository`: the row with an
  `admin_id`, whichever admin created it); any admin with the permission uses it, and **Create
  Wallet** refuses while it exists. `Listeners/Admin` (`user.admin.delete.before`) hands the wallet,
  bank account and admin transfers to another admin before the cascading foreign keys would delete them.
- **Buyer wallets:** `mangopay_wallets.cart_id` is `nullOnDelete`, so removing a customer's first
  cart never deletes the customer's wallet row.
- **Seller onboarding:** sellers register bank details (IBAN, GB, US, CA or other), submit KYC
  documents and view their transactions. Seller controllers run on the `seller` guard (a Marketplace
  seller is a standalone entity); scope every seller read and write to the authenticated seller.
- **Admin escrow (shared orders):** `ReleaseAmount::execute()` works from the order's Marketplace
  seller orders (never from product ownership — offers are on admin products). Each approved seller
  gets one transfer of `base_seller_total_invoiced` less their refunded share and less what Marketplace
  already recorded as paid, recorded with `TransactionRepository::paySeller()` (method `MangoPay`);
  the remainder of the escrow (commission, admin items, shipping) goes to the store's admin wallet
  last. Amounts are planned before any transfer, a `FAILED` transfer throws and leaves the escrow
  pending, a retry pays only what is unpaid, and a cache lock serialises releases of one escrow.
  Shipping is never added to a seller payout here (core Marketplace keeps shipping out of payouts).
- **Refunds:** `RefundController` sends the refund's `grand_total` (base) back to the original PayIn,
  validates like core's refund (shipping cap, items of this order only), refuses an escrow that was
  already released, and locks per order. The refund button is injected into the core order page
  through a listener on `bagisto.admin.sales.order.page_action.after`
  (`mangopay::admin.sales.orders.refund-button`), not by overriding the core view.
- **API helper:** `Helpers\MangopayHelper` picks the `SANDBOX` / `PRODUCTION` base URL from
  `...mangopay_standard.sandbox`, reads `clientid` / `passphrase`, and uses the private
  `storage_path('app/mangopay')` as the SDK temp folder (it holds the OAuth token — never a public path).
- **Seller onboarding storage:** bank detail forms save only `MangopayHelper::BANK_DETAIL_FIELDS` for
  the signed-in owner; KYC copies go to the private `local` disk under `kyc-documents/{seller_id}`.

## Conventions

- **Tailwind CSS 4:** the module ships no stylesheet. Core and Marketplace v2.5 compile only the
  classes their own sources use, so admin views may only use classes the core admin build compiles
  and seller views only those the Marketplace build compiles; use the v4 spelling (`mb-0!`, not
  `!mb-0`). The seller menu icon `mp-transaction-icon` is one Marketplace's seller build compiles.
- **Databases:** MySQL 8.0, MariaDB 10.11 and PostgreSQL 16, with or without a `DB_PREFIX`. The module
  has no raw SQL; keep it that way, or use `db_grammar()` and `DB::getTablePrefix()` for tables and
  builder aliases.
- Translation keys are kebab-case (core v2.5 renamed its underscored keys); every user-facing string
  goes through `trans()` in all 22 locales.
- All DB access goes through a repository (a DataGrid's `prepareQueryBuilder` is the exception); no
  comments inside method bodies; every method and property carries a docblock.
- **Fix a bug in the layer it comes from.** A bug that appears only with this module on Marketplace
  is fixed here; a bug of Marketplace on core is fixed in Marketplace; a bug that reproduces with core
  Bagisto alone is fixed in core through the Bagisto fork (a `fix/...` branch, never the store app's
  `packages/Webkul/*`). Never work around a Marketplace or core bug inside this module. Existing
  Marketplace "Core workarounds (remove when fixed upstream)" entries stay until core ships the fix.
- **Secrets:** never commit MangoPay client ids, passphrases, API keys, tokens or passwords — not in
  code, docs, fixtures or tests. They live only in the admin configuration; tests use the fakes in
  `tests/Doubles`.

## Tests & CI

- Pest: self-contained `Webkul\MangoPay\Tests\MangoPayTestCase` (extends `Tests\TestCase`, uses the
  `ProvideMangoPayHelpers` concern); `tests/Doubles` (`FakeMangoPayApi`, `FakeService`) fake the
  MangoPay API. CI registers the phpunit suite `MangoPay` over `tests/Feature` and `tests/Unit` and runs
  `env -u APP_ENV -u APP_DEBUG php artisan test --testsuite="MangoPay"` (the `env -u` is required — a
  `local` APP_ENV leaves CSRF on).
- Playwright: `tests/e2e-pw`. Its `package.json` has no scripts: from that directory run
  `npm install && npx playwright install chromium && npx playwright test` against a running app; the
  base URL comes from `APP_URL`, admin URLs from `APP_ADMIN_URL`. Run the specs in order (admin/01
  configures the method, shop/02 creates the product the later specs buy). Sandbox credentials come
  only from `MANGOPAY_CLIENT_ID` / `MANGOPAY_PASSPHRASE` (masked CI variables); without them
  placeholders are saved and the two paying checkout specs skip. `shop/04-forged-return` proves a return
  the checkout never started places no order. Never commit credentials; `test-data/` and `.state/`
  are run output (git-ignored).
- CI (`.gitlab-ci.yml`, image `webkul/bagisto:2.5.0`) is two isolated stages (Pest, then
  Playwright), each doing a full install: clone Marketplace `-b stable/2.5`,
  `composer require picqer/php-barcode-generator` (a Marketplace dependency the stock lock prunes) and
  the MangoPay SDK, then `marketplace:install` and `mangopay:install`.

## Validation Checklist (before calling a change done)

1. `vendor/bin/pint` and `available-extensions/laravel/code-style/bin/code-style` on
   `packages/Webkul/MangoPay/src` — no violations.
2. The `MangoPay` Pest suite passes; run Playwright when the UI or a flow changed.
3. New translation keys exist in all 22 locales; `php artisan optimize:clear`.
4. Works under an `APP_ADMIN_URL` other than `admin`, a `DB_PREFIX`, and on PostgreSQL.
5. CHANGELOG entries only for features (`+`), fixes (`!`) and modifications (`*`).
