# UPGRADE Guide

- [Upgrading To v2.5.0.0 From v2.4.11.0](#upgrading-to-v2500-from-v24110)

## Upgrading To v2.5.0.0 From v2.4.11.0

### Updating Dependencies

**Impact Probability: High**

This release requires **Bagisto v2.5.0** and **Marketplace v2.5.0.x**. Upgrade both first, then:

```bash
composer dump-autoload

php artisan optimize:clear
```

There are no new migrations and the database schema is unchanged.

### Route Names Are snake_case

**Impact Probability: Medium**

Following core v2.5, the module's hyphenated route names were renamed. URLs are unchanged; code that calls `route()` with an old name throws `RouteNotFoundException`.

| Old name | New name |
| --- | --- |
| `admin.mangopay.create-wallet` | `admin.mangopay.create_wallet` |
| `admin.mangopay.save-bank-details` | `admin.mangopay.save_bank_details` |
| `admin.mangopay.save-bank-details.store` | `admin.mangopay.save_bank_details.store` |
| `admin.mangopay.release-amount` | `admin.mangopay.release_amount` |
| `mangopay.standard.redirect-mangopay` | `mangopay.standard.redirect_mangopay` |

### Admin Wallet Is Created With A POST

**Impact Probability: Low**

`admin.mangopay.create_wallet` (`{admin_url}/mangopay/wallets/create`) now accepts only `POST` with a CSRF token; the **Create Wallet** button on the wallet page is a form. A bookmark or a link to the old `GET` URL answers `405`.

### Admin Permission For MangoPay Refunds

**Impact Probability: Medium**

Core v2.5 refuses an admin route that no ACL entry names for every role whose permission type is not **All**. The refund form and its save (`admin.mangopay.refund.create` / `admin.mangopay.refund.store`) are now covered by the new ACL key `marketplace.mangopay.refund` (**Marketplace → MangoPay → MangoPay Refund**). Grant it to every custom role that issues MangoPay refunds; the **MangoPay Refund** button on the order page appears only for roles that hold both it and `sales.refunds.create`.

### Order Placement After The MangoPay Return

**Impact Probability: Medium**

The return URL no longer places an order on its own. The order is created only when the return carries the PayIn this checkout started (`transactionId`) and the MangoPay API reports that PayIn as `SUCCEEDED`, credited to the buyer's wallet, for the cart's base grand total in the base currency. A failed, pending, replayed or forged return sends the customer back to the cart with an error and places no order.

The card payment and the escrowed amount are now the cart's and order's **base** grand total, in the base currency, so a customer browsing in another currency is charged the right amount. Escrow rows written by earlier versions keep the value they were stored with.

### Escrow Release On Shared Orders

**Impact Probability: High**

**Release Amount** now works from the order's Marketplace seller orders instead of looking up the owner of each product:

- Every approved seller of the order is transferred once: their invoiced payout (`base_seller_total_invoiced`), less their share of what was refunded (net items after commission, plus their tax) and less what Marketplace already recorded as paid to them for that order.
- Each seller transfer is also recorded as a Marketplace seller payout with the method `MangoPay`, so **Marketplace → Payment Requests** shows the seller as paid and the admin cannot pay the same amount again by hand.
- The rest of the escrow (commission, the admin's own items, shipping, the payout of an unapproved seller) goes to the store's admin wallet in one transfer, recorded as **Transfer to admin from buyer**. Earlier versions made one commission transfer per seller.
- Sellers of offers on admin products are now paid; earlier versions sent their share to the admin.
- Every amount is checked before money moves. A transfer MangoPay refuses stops the release with its message and leaves the escrow **Pending**; releasing it again pays only what is still unpaid. Two releases of the same escrow cannot run at the same time.

### MangoPay Refunds

**Impact Probability: Medium**

- The amount sent to MangoPay is the refund's grand total. Earlier versions added the adjustment refund and subtracted the adjustment fee a second time.
- Refund shipping is capped at the invoiced shipping not yet refunded, items of another order are rejected, and only one refund of an order runs at a time.
- An order whose escrow was already released can no longer be refunded through MangoPay, because the buyer's wallet no longer holds its funds.

### Bank Details And KYC Documents

**Impact Probability: Low**

- The admin and seller bank details forms save only the bank fields, for the signed-in admin or seller; posted `admin_id` / `seller_id` values are ignored, and the account type must be one of `IBAN`, `GB`, `US`, `CA` or `OTHER`.
- KYC uploads must be a PDF, JPEG or PNG of at most 10 MB, with one of MangoPay's document types, and the copy Bagisto keeps is stored on the private `local` disk under `kyc-documents/{seller_id}` instead of the public disk. Move the documents uploaded by earlier versions out of the public storage:

  ```bash
  mkdir -p storage/app/kyc-documents
  cp -a storage/app/public/kyc/. storage/app/kyc-documents/
  rm -rf storage/app/public/kyc

  php artisan tinker --execute="DB::table('mangopay_kyc')->where('file', 'like', 'kyc/%')->update(['file' => DB::raw(\"REPLACE(file, 'kyc/', 'kyc-documents/')\")]);"
  ```

### MangoPay SDK Token Cache

**Impact Probability: Low**

The MangoPay SDK now caches its OAuth token in `storage/app/mangopay`, created on first use, instead of the publicly served `storage/app/public/mangopay`. Delete the old folder:

```bash
rm -rf storage/app/public/mangopay
```

### One Admin Wallet For The Store

**Impact Probability: Medium**

The admin wallet and admin bank account used to belong to the admin user who created them, so another admin could not release escrow ("admin wallet not found") and pressing **Create Wallet** again replaced the stored wallet. The store now has one admin wallet: every admin allowed to use the MangoPay pages sees and uses it, escrow releases always pay into it, and **Create Wallet** is refused while it exists. Existing rows keep working without a data change. If several admins created wallets in an older version, the oldest admin wallet (lowest id) is the store's; move any balance left in the others from the MangoPay dashboard. Deleting an admin no longer deletes the store wallet: it is handed to another admin first.

### MangoPay Hooks

**Impact Probability: Medium**

A new public route `GET mangopay/webhook` (`mangopay.webhook`) receives MangoPay hook notifications, so a customer who closes the browser after 3-D Secure still gets the order. Register the hooks as described in the README's "Webhook setup" (`PAYIN_NORMAL_SUCCEEDED` and `PAYIN_NORMAL_FAILED`). Without them a payment whose customer never returns to the store stays in the customer's MangoPay wallet with no order, as in earlier versions.

### Charges Without An Order Are Refunded

**Impact Probability: Low**

When MangoPay confirms a payment that cannot become an order (the cart changed meanwhile, or the order could not be created, for example because stock ran out), the PayIn is refunded to the customer's card instead of staying in the customer's wallet, and the customer is told so.

### Buyer Wallets Survive Cart Deletion

**Impact Probability: Low**

`mangopay_wallets.cart_id` now references the cart with `ON DELETE SET NULL` instead of `ON DELETE CASCADE`, so deleting a customer's first cart no longer deletes the customer's wallet row. A fresh install gets the new key; an existing install keeps the old one until you run, once, from `php artisan tinker` (MySQL, MariaDB and PostgreSQL, with or without a table prefix; safe to run again):

```php
Schema::table('mangopay_wallets', function (Illuminate\Database\Schema\Blueprint $table) {
    $table->dropForeign(['cart_id']);

    $table->foreign('cart_id')->references('id')->on('cart')->nullOnDelete();
});
```

