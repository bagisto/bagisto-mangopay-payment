# Bagisto Marketplace MangoPay Payment

A payment module that integrates MangoPay's payment infrastructure with Bagisto Marketplace, letting customers pay via supported card methods while funds are held in escrow, sellers onboard with bank details and KYC, and admins release payouts and issue refunds.

![Version](https://img.shields.io/badge/Version-v2.5.0.0-green)
![Bagisto](https://img.shields.io/badge/Bagisto-v2.5.0-blue)

## Contents

- [Introduction](#introduction)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Webhook setup](#webhook-setup)
- [Console commands](#console-commands)

## Introduction

The **Bagisto Marketplace MangoPay Payment Gateway Integration** is a payment module that enables secure and seamless online transactions within your Bagisto marketplace. It integrates MangoPay's payment infrastructure with Bagisto Marketplace, allowing customers to make payments via supported card methods and enabling admins to manage transactions efficiently.

Buyer funds are held in a MangoPay wallet (escrow) until the admin releases them: each seller receives their share of the order and the commission is transferred to the admin wallet. This module enhances marketplace operations by providing secure payment processing, transaction tracking, and refund management.

## Features

- Enable or disable the MangoPay payment method from the admin panel, with sandbox and production environment support.
- Configure the method title, description and logo shown at checkout.
- MangoPay payment option on the checkout page; customers pay with supported card methods through a secure redirect and confirmation flow.
- Buyer funds are held in escrow; the order is placed only once MangoPay confirms the card payment. The admin releases each order's escrow: every seller of the order receives their payout once (recorded as a Marketplace payout), and the commission, the admin's own items and shipping go to the admin wallet.
- Sellers register bank details (IBAN, GB, US, CA or other) and upload KYC documents from the seller dashboard, and view their MangoPay transactions.
- The admin manages the admin wallet, bank details, transactions and escrowed amounts from **Marketplace → MangoPay**.
- Refunds are processed through the MangoPay API from the admin order page.
- PCI-compliant payment handling via MangoPay; no sensitive card data is stored in Bagisto.

## Requirements

- **Bagisto**: v2.5.0
- **Bagisto Marketplace**: v2.5.0.x
- **PHP**: 8.4 or higher
- **Database**: MySQL 8.0, MariaDB 10.11 or PostgreSQL 16
- **MangoPay PHP SDK**: v4.0 or higher (installed via Composer during setup)

## Installation

1. Unzip the respective extension zip and then merge the `packages` folder into the project root directory.

2. Go to the `composer.json` file and add the following line under `psr-4`:

   ```json
   "Webkul\\MangoPay\\": "packages/Webkul/MangoPay/src"
   ```

3. Install the MangoPay PHP library:

   ```bash
   composer require mangopay4/php-sdk:^4.0
   ```

4. Regenerate the autoloader:

   ```bash
   composer dump-autoload
   ```

5. Go to the `bootstrap/providers.php` file and register the service provider **after** the Marketplace service provider:

   ```php
   Webkul\MangoPay\Providers\MangoPayServiceProvider::class,
   ```

6. Run the installer to complete the setup:

   ```bash
   php artisan mangopay:install
   ```

## Configuration

The MangoPay payment method is configured under **Admin → Configuration → Sales → Payment Methods → MangoPay**:

| Field | Controls |
| --- | --- |
| Status | Enable or disable the MangoPay payment method |
| Title | Method title shown at checkout |
| Description | Method description shown at checkout |
| Logo | Method image shown at checkout |
| Client Id | MangoPay API client id |
| Passphrase | MangoPay API passphrase |
| Sandbox | Toggle between sandbox and production environments |
| Sort Order | Position of the method in the checkout list |

The admin escrow area (**Marketplace → MangoPay**) appears once the method is active. The store has one admin wallet, which any admin allowed to use MangoPay manages. Sellers manage their bank details and KYC documents from the **MangoPay** menu of the seller dashboard whenever the marketplace is enabled.

## Webhook setup

A customer can close the browser after paying with 3-D Secure, before MangoPay sends them back to the store. MangoPay then still notifies the store, and the module places the order from that notification with the same checks as the return page: the PayIn is read back from the MangoPay API and must belong to the cart, have succeeded and charge exactly the cart's total in the base currency, and it places one order only. A charge that cannot become an order is refunded.

1. Note the hook URL of your store: `https://<your-store>/mangopay/webhook` (route `mangopay.webhook`, a public `GET`, as MangoPay calls it).
2. Register two hooks for that URL, in the MangoPay dashboard (**Developers → Hooks**) or with the API (`POST /v2.01/{ClientId}/hooks`), for the event types **`PAYIN_NORMAL_SUCCEEDED`** and **`PAYIN_NORMAL_FAILED`**. Use the same environment (sandbox or production) as the **Sandbox** setting.
3. Test it in the sandbox: start a MangoPay checkout, complete the 3-D Secure step, then close the tab before the store's success page loads. Within a minute the order appears under **Sales → Orders** as *Processing* with its invoice, and `storage/logs/laravel.log` records `MangoPay hook: PayIn … placed`. Calling the URL again for the same PayIn changes nothing.

The hook only names the PayIn; nothing in the request is trusted, so it needs no secret and no CSRF exemption.

## Console commands

| Command | Purpose |
| --- | --- |
| `mangopay:install` | Installs and configures the MangoPay package |
