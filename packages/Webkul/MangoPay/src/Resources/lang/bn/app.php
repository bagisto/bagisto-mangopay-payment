<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'আপনাকে কয়েক সেকেন্ডের মধ্যে MangoPay ওয়েবসাইটে পুনঃনির্দেশিত করা হবে।',
            'redirect-button' => '১০ সেকেন্ডের মধ্যে পুনঃনির্দেশিত না হলে এখানে ক্লিক করুন...',
            'unavailable' => 'MangoPay পেমেন্ট পদ্ধতি বর্তমানে উপলব্ধ নয়। অনুগ্রহ করে অন্য একটি পেমেন্ট পদ্ধতি বেছে নিন বা অ্যাডমিনিস্ট্রেটরের সাথে যোগাযোগ করুন।',
            'canceled' => 'MangoPay পেমেন্ট বাতিল করা হয়েছে।',
            'cart-not-found' => 'MangoPay কার্ট পাওয়া যায়নি। অনুগ্রহ করে আবার অর্ডার দেওয়ার চেষ্টা করুন।',
            'wallet-not-found' => 'এই অর্ডারের জন্য MangoPay ওয়ালেট পাওয়া যায়নি।',
            'payment-not-confirmed' => 'আপনার MangoPay পেমেন্ট নিশ্চিত করা যায়নি, তাই কোনো অর্ডার দেওয়া হয়নি।',
            'payment-refunded' => 'আপনার কার্ড থেকে টাকা কাটা হয়েছে কিন্তু অর্ডার দেওয়া যায়নি, তাই পেমেন্ট ফেরত দেওয়া হয়েছে।',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay পেমেন্ট সেটিংস শুধুমাত্র বিক্রেতাদের জন্য উপলব্ধ।',

            'bank-details' => [
                'title' => 'ব্যাংক বিবরণ',
                'save-btn' => 'ব্যাংক বিবরণ সংরক্ষণ করুন',
                'save-success' => 'ব্যাংক বিবরণ সফলভাবে সংরক্ষিত হয়েছে।',
            ],

            'kyc' => [
                'title' => 'KYC নথি',
                'create-title' => 'KYC নথি যোগ করুন',
                'create-btn' => 'নথি যোগ করুন',
                'save-btn' => 'নথি আপলোড করুন',
                'save-success' => 'KYC নথি সফলভাবে আপলোড হয়েছে।',
                'bank-required' => 'অনুগ্রহ করে KYC নথি আপলোড করার আগে আপনার ব্যাংক বিবরণ জমা দিন।',
                'type' => 'নথির ধরন',
                'file' => 'নথির ফাইল',

                'types' => [
                    'identity-proof' => 'পরিচয় প্রমাণ',
                    'registration-proof' => 'নিবন্ধন প্রমাণ',
                    'articles-of-association' => 'সংঘবিধি',
                    'shareholder-declaration' => 'শেয়ারহোল্ডার ঘোষণা',
                    'address-proof' => 'ঠিকানার প্রমাণ',
                ],
            ],

            'transactions' => [
                'title' => 'লেনদেন',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'সংরক্ষণ করুন',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'সাধারণ',
                'description' => 'বিবরণ',
                'title' => 'শিরোনাম',
                'enable' => 'সক্রিয় করুন',
                'sandbox' => 'স্যান্ডবক্স',
                'status' => 'অবস্থা',
                'sort-order' => 'সাজানোর ক্রম',
                'client-id' => 'ক্লায়েন্ট আইডি',
                'passphrase' => 'পাসফ্রেজ',
                'logo' => 'লোগো',
                'logo-information' => 'ছবির রেজোলিউশন 55px × 45px হওয়া উচিত',
                'production-mode-info' => 'প্রোডাকশন মোডের জন্য স্যান্ডবক্স নিষ্ক্রিয় করুন।',
                'info' => 'MangoPay পেমেন্ট গেটওয়ে সেটিংস',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay আইডি',
            'wallet-id' => 'ওয়ালেট আইডি',
            'no-of-days' => 'কত দিন পরে অ্যাডমিন হোল্ডকৃত অর্থ মুক্ত করতে পারবেন তা নির্ধারণ করুন',
            'mangopay-refund' => 'MangoPay রিফান্ড',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay ব্যাংক বিবরণ',
            'type' => 'ধরণ',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'মালিকের নাম',
            'owner-address' => 'মালিকের ঠিকানা',
            'owner-city' => 'মালিকের শহর',
            'owner-region' => 'মালিকের অঞ্চল',
            'owner-postal-code' => 'মালিকের পোস্টাল কোড',
            'country' => 'দেশ',
            'account-number' => 'অ্যাকাউন্ট নম্বর',
            'sortcode' => 'সোর্ট কোড',
            'aba' => 'ABA',
            'bank-name' => 'ব্যাংকের নাম',
            'institution-number' => 'প্রতিষ্ঠান নম্বর',
            'branch-code' => 'শাখা কোড',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'ধরণ',
            'file' => 'ফাইল',
            'status' => 'অবস্থা',
            'id' => 'আইডি',
            'created-at' => 'তৈরির তারিখ',
        ],

        'wallet' => [
            'module-name' => 'MangoPay অ্যাডমিন ওয়ালেট শংসাপত্র',
            'wallet-id' => 'ওয়ালেট আইডি',
            'mangopay-id' => 'MangoPay আইডি',
            'create-wallet' => 'ওয়ালেট তৈরি করুন',
        ],

        'transaction' => [
            'module-name' => 'MangoPay লেনদেন',
            'transaction-id' => 'লেনদেন আইডি',
            'amount' => 'পরিমাণ',
            'message' => 'বার্তা',
            'status' => 'অবস্থা',
            'id' => 'আইডি',
            'success' => 'সফল',
            'failed' => 'ব্যর্থ',
        ],

        'amount' => [
            'module-name' => 'এস্ক্রো অর্থ পরিচালনা',
        ],

        'datagrid' => [
            'order-id' => 'অর্ডার আইডি',
            'wallet-id' => 'ওয়ালেট আইডি',
            'escrowed-amount' => 'এস্ক্রো অর্থ',
            'created-at' => 'তৈরির তারিখ',
            'transaction-id' => 'লেনদেন আইডি',
            'amount' => 'পরিমাণ',
            'message' => 'বার্তা',
            'status' => 'অবস্থা',
            'pay' => 'পরিশোধ করুন',
            'release-amount' => 'অর্থ মুক্ত করুন',
            'released' => 'রিলিজ করা হয়েছে',
            'pending' => 'মুলতুবি',
        ],

        'response' => [
            'wallet-not-found' => 'ওয়ালেট পাওয়া যায়নি। অনুগ্রহ করে প্রথমে একটি ওয়ালেট তৈরি করুন।',
            'wallet-create-success' => 'ওয়ালেট এবং MangoPay আইডি সফলভাবে তৈরি হয়েছে।',
            'bank-details-create-success' => 'ব্যাংক বিবরণ সফলভাবে সংরক্ষিত হয়েছে।',
            'amount-release-success' => 'এসক্রো করা পরিমাণ সফলভাবে রিলিজ করা হয়েছে।',
            'escrow-not-found' => 'এসক্রো রেকর্ড পাওয়া যায়নি।',
            'already-released' => 'এই এসক্রো করা অর্থ ইতিমধ্যে ছাড়া হয়েছে।',
            'buyer-wallet-not-found' => 'ক্রেতার ওয়ালেট পাওয়া যায়নি।',
            'admin-wallet-not-found' => 'অ্যাডমিন ওয়ালেট পাওয়া যায়নি।',
            'unsupported-bank-type' => 'অসমর্থিত ব্যাংক অ্যাকাউন্টের ধরন: :type',
            'request-in-progress' => 'এই অর্ডারের জন্য আরেকটি অনুরোধ চলছে। অনুগ্রহ করে কিছুক্ষণ পরে আবার চেষ্টা করুন।',
            'wallet-exists' => 'স্টোরের ইতিমধ্যে একটি MangoPay ওয়ালেট আছে; এটি প্রতিস্থাপন করা হয় না।',
            'insufficient-escrow' => 'এসক্রো করা পরিমাণ এই অর্ডারের বিক্রেতাদের পেআউট কভার করে না।',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'পণ্যের নাম',
            'qty-ordered' => 'অর্ডারকৃত পরিমাণ',
            'qty-to-refund' => 'ফেরত দেওয়া পরিমাণ',
            'update-qty' => 'পরিমাণ আপডেট করুন',
            'refund-summary' => 'ফেরতের সারসংক্ষেপ',
            'refund-shipping' => 'শিপিং ফেরত',
            'adjustment-refund' => 'সমন্বয় ফেরত',
            'adjustment-fee' => 'সমন্বয় ফি',
            'subtotal' => 'সাবটোটাল',
            'tax' => 'কর',
            'discount' => 'ছাড়',
            'grand-total' => 'মোট টোটাল',
        ],
    ],
];
