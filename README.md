# Introduction

Bagisto Mangopay Payment Gateway is an advanced and feature-rich module that will integrate Bagisto store with the Mangopay Payment Gateway. This module allows the admin to collect online payments from the customer's Mangopay accounts.

It packs in lots of demanding features that allows your business to scale in no time:

- Admin must register himself on Mangopay website to get Client Id and Passphrase.
- Enable/disable the payment solution.
- Set Bagisto Mangopay Payment Gateway module title.
- Provide secure, trusted and fast payment to the customers.
- The customer can select the Mangopay payment method available on the checkout page.
- Check placed orders details like invoices and transaction.
- Accepts all the cards that Mangopay supports.
- Supports Refund


## Requirements:

- **Bagisto**: v1.3.2.
- **Bagisto Marketplace**: v1.3.2.

- **NOTE**: This Module is an add-on of Marketplace module.You need to Install the Markeplace module first to use this add-on.

## Installation :
- Run the following command
```
composer require bagisto/bagisto-mangopay-payment
```

- Goto config/concord.php file and add following line under 'modules'
```php
\Webkul\MangoPay\Providers\ModuleServiceProvider::class
```

- Run the command below to install the Mangopay php library:

```
composer require mangopay/php-sdk-v2:^2.3
```

- Goto Storage/app/public create a folder name mangopay there

- Run these commands below to complete the setup
```
composer dump-autoload
```

```
php artisan migrate
php artisan route:cache
php artisan config:cache
```

```
php artisan db:seed --class=Webkul\\MangoPay\\Database\\Seeders\\DatabaseSeeder
```

- If your are windows user then run the below command-

```
php artisan db:seed --class="Webkul\MangoPay\Database\Seeders\DatabaseSeeder"
```

```
php artisan vendor:publish --force
```

-> Press the number before MangoPayServiceProvider and then press enter to publish all assets and configurations.

> now execute the project on your specified domain.
