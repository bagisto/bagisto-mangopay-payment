<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'تا چند ثانیه دیگر به وب‌سایت MangoPay هدایت خواهید شد.',
            'redirect-button' => 'اگر ظرف ۱۰ ثانیه هدایت نشدید، اینجا کلیک کنید...',
            'unavailable' => 'روش پرداخت MangoPay در حال حاضر در دسترس نیست. لطفاً روش پرداخت دیگری را انتخاب کنید یا با مدیر تماس بگیرید.',
            'canceled' => 'پرداخت MangoPay لغو شد.',
            'cart-not-found' => 'سبد خرید MangoPay یافت نشد. لطفاً دوباره برای ثبت سفارش تلاش کنید.',
            'wallet-not-found' => 'کیف پول MangoPay برای این سفارش یافت نشد.',
            'payment-not-confirmed' => 'پرداخت MangoPay شما تأیید نشد، بنابراین هیچ سفارشی ثبت نشد.',
            'payment-refunded' => 'مبلغ از کارت شما کسر شد اما سفارش ثبت نشد، بنابراین پرداخت بازگردانده شد.',
        ],

        'mangopay' => [
            'not-a-seller' => 'تنظیمات پرداخت MangoPay فقط برای فروشندگان در دسترس است.',

            'bank-details' => [
                'title' => 'جزئیات بانکی',
                'save-btn' => 'ذخیره اطلاعات بانکی',
                'save-success' => 'اطلاعات بانکی با موفقیت ذخیره شد.',
            ],

            'kyc' => [
                'title' => 'مدارک KYC',
                'create-title' => 'افزودن مدرک KYC',
                'create-btn' => 'افزودن مدرک',
                'save-btn' => 'بارگذاری مدرک',
                'save-success' => 'مدرک KYC با موفقیت بارگذاری شد.',
                'bank-required' => 'لطفاً پیش از بارگذاری مدارک KYC، اطلاعات بانکی خود را ارسال کنید.',
                'type' => 'نوع مدرک',
                'file' => 'فایل مدرک',

                'types' => [
                    'identity-proof' => 'مدرک هویتی',
                    'registration-proof' => 'مدرک ثبت شرکت',
                    'articles-of-association' => 'اساسنامه',
                    'shareholder-declaration' => 'اظهارنامه سهامداران',
                    'address-proof' => 'مدرک آدرس',
                ],
            ],

            'transactions' => [
                'title' => 'تراکنش‌ها',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'ذخیره',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'عمومی',
                'description' => 'توضیحات',
                'title' => 'عنوان',
                'enable' => 'فعال‌سازی',
                'sandbox' => 'محیط آزمایشی',
                'status' => 'وضعیت',
                'sort-order' => 'ترتیب نمایش',
                'client-id' => 'شناسه مشتری',
                'passphrase' => 'عبارت عبور',
                'logo' => 'لوگو',
                'logo-information' => 'وضوح تصویر باید 55px × 45px باشد',
                'production-mode-info' => 'برای حالت تولید، محیط آزمایشی را غیرفعال کنید.',
                'info' => 'تنظیمات درگاه پرداخت MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'شناسه Mangopay',
            'wallet-id' => 'شناسه کیف پول',
            'no-of-days' => 'تعداد روزهایی را تعیین کنید که پس از آن مدیر بتواند مبلغ نگهداری شده را آزاد کند',
            'mangopay-refund' => 'بازپرداخت MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'اطلاعات بانکی MangoPay',
            'type' => 'نوع',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'نام صاحب حساب',
            'owner-address' => 'آدرس صاحب حساب',
            'owner-city' => 'شهر صاحب حساب',
            'owner-region' => 'منطقه صاحب حساب',
            'owner-postal-code' => 'کد پستی صاحب حساب',
            'country' => 'کشور',
            'account-number' => 'شماره حساب',
            'sortcode' => 'کد شعبه',
            'aba' => 'ABA',
            'bank-name' => 'نام بانک',
            'institution-number' => 'شماره مؤسسه',
            'branch-code' => 'کد شعبه',
        ],

        'kyc' => [
            'module-name' => 'احراز هویت MangoPay (KYC)',
            'type' => 'نوع',
            'file' => 'فایل',
            'status' => 'وضعیت',
            'id' => 'شناسه',
            'created-at' => 'تاریخ ایجاد',
        ],

        'wallet' => [
            'module-name' => 'اطلاعات کیف پول مدیر MangoPay',
            'wallet-id' => 'شناسه کیف پول',
            'mangopay-id' => 'شناسه MangoPay',
            'create-wallet' => 'ایجاد کیف پول',
        ],

        'transaction' => [
            'module-name' => 'تراکنش MangoPay',
            'transaction-id' => 'شناسه تراکنش',
            'amount' => 'مبلغ',
            'message' => 'پیام',
            'status' => 'وضعیت',
            'id' => 'شناسه',
            'success' => 'موفق',
            'failed' => 'ناموفق',
        ],

        'amount' => [
            'module-name' => 'مدیریت مبلغ امانی',
        ],

        'datagrid' => [
            'order-id' => 'شناسه سفارش',
            'wallet-id' => 'شناسه کیف پول',
            'escrowed-amount' => 'مبلغ امانی',
            'created-at' => 'تاریخ ایجاد',
            'transaction-id' => 'شناسه تراکنش',
            'amount' => 'مبلغ',
            'message' => 'پیام',
            'status' => 'وضعیت',
            'pay' => 'پرداخت',
            'release-amount' => 'آزادسازی مبلغ',
            'released' => 'آزاد شده',
            'pending' => 'در انتظار',
        ],

        'response' => [
            'wallet-not-found' => 'کیف پول یافت نشد. لطفاً ابتدا یک کیف پول ایجاد کنید.',
            'wallet-create-success' => 'کیف پول و شناسه MangoPay با موفقیت ایجاد شد.',
            'bank-details-create-success' => 'اطلاعات بانکی با موفقیت ذخیره شد.',
            'amount-release-success' => 'مبلغ امانی با موفقیت آزاد شد.',
            'escrow-not-found' => 'رکورد امانی یافت نشد.',
            'already-released' => 'این مبلغ امانی قبلاً آزاد شده است.',
            'buyer-wallet-not-found' => 'کیف پول خریدار یافت نشد.',
            'admin-wallet-not-found' => 'کیف پول مدیر یافت نشد.',
            'unsupported-bank-type' => 'نوع حساب بانکی پشتیبانی نمی‌شود: :type',
            'request-in-progress' => 'درخواست دیگری برای این سفارش در حال انجام است. لطفاً کمی بعد دوباره تلاش کنید.',
            'wallet-exists' => 'فروشگاه از قبل یک کیف پول MangoPay دارد؛ جایگزین نمی‌شود.',
            'insufficient-escrow' => 'مبلغ امانی، پرداخت‌های فروشندگان این سفارش را پوشش نمی‌دهد.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'نام محصول',
            'qty-ordered' => 'تعداد سفارش‌شده',
            'qty-to-refund' => 'تعداد برای بازپرداخت',
            'update-qty' => 'به‌روزرسانی تعداد',
            'refund-summary' => 'خلاصه بازپرداخت',
            'refund-shipping' => 'بازپرداخت هزینه حمل و نقل',
            'adjustment-refund' => 'بازپرداخت تنظیمی',
            'adjustment-fee' => 'هزینه تنظیمی',
            'subtotal' => 'جمع جزئی',
            'tax' => 'مالیات',
            'discount' => 'تخفیف',
            'grand-total' => 'جمع کل',
        ],
    ],
];
