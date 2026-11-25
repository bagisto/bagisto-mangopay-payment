<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'आपको कुछ ही सेकंड में MangoPay वेबसाइट पर पुनर्निर्देशित किया जाएगा।',
            'redirect-button' => 'यदि आप 10 सेकंड में पुनर्निर्देशित नहीं होते हैं तो यहाँ क्लिक करें...',
            'unavailable' => 'MangoPay भुगतान विधि अभी उपलब्ध नहीं है। कृपया कोई अन्य भुगतान विधि चुनें या व्यवस्थापक से संपर्क करें।',
            'canceled' => 'MangoPay भुगतान रद्द कर दिया गया है।',
            'cart-not-found' => 'MangoPay कार्ट नहीं मिला। कृपया फिर से ऑर्डर देने का प्रयास करें।',
            'wallet-not-found' => 'इस ऑर्डर के लिए MangoPay वॉलेट नहीं मिला।',
            'payment-not-confirmed' => 'आपके MangoPay भुगतान की पुष्टि नहीं हो सकी, इसलिए कोई ऑर्डर नहीं दिया गया।',
            'payment-refunded' => 'आपके कार्ड से राशि काटी गई लेकिन ऑर्डर नहीं दिया जा सका, इसलिए भुगतान वापस कर दिया गया है।',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay भुगतान सेटिंग्स केवल विक्रेताओं के लिए उपलब्ध हैं।',

            'bank-details' => [
                'title' => 'बैंक विवरण',
                'save-btn' => 'बैंक विवरण सहेजें',
                'save-success' => 'बैंक विवरण सफलतापूर्वक सहेजा गया।',
            ],

            'kyc' => [
                'title' => 'KYC दस्तावेज़',
                'create-title' => 'KYC दस्तावेज़ जोड़ें',
                'create-btn' => 'दस्तावेज़ जोड़ें',
                'save-btn' => 'दस्तावेज़ अपलोड करें',
                'save-success' => 'KYC दस्तावेज़ सफलतापूर्वक अपलोड किया गया।',
                'bank-required' => 'कृपया KYC दस्तावेज़ अपलोड करने से पहले अपना बैंक विवरण जमा करें।',
                'type' => 'दस्तावेज़ का प्रकार',
                'file' => 'दस्तावेज़ फ़ाइल',

                'types' => [
                    'identity-proof' => 'पहचान प्रमाण',
                    'registration-proof' => 'पंजीकरण प्रमाण',
                    'articles-of-association' => 'संस्था का ज्ञापन',
                    'shareholder-declaration' => 'शेयरधारक घोषणा',
                    'address-proof' => 'पता प्रमाण',
                ],
            ],

            'transactions' => [
                'title' => 'लेन-देन',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'सहेजें',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'सामान्य',
                'description' => 'विवरण',
                'title' => 'शीर्षक',
                'enable' => 'सक्षम करें',
                'sandbox' => 'सैंडबॉक्स',
                'status' => 'स्थिति',
                'sort-order' => 'क्रमबद्धता क्रम',
                'client-id' => 'क्लाइंट आईडी',
                'passphrase' => 'पासफ़्रेज़',
                'logo' => 'लोगो',
                'logo-information' => 'छवि का रिज़ॉल्यूशन 55px × 45px होना चाहिए',
                'production-mode-info' => 'प्रोडक्शन मोड के लिए सैंडबॉक्स को अक्षम करें।',
                'info' => 'MangoPay पेमेंट गेटवे सेटिंग्स',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay आईडी',
            'wallet-id' => 'वॉलेट आईडी',
            'no-of-days' => 'उन दिनों की संख्या निर्धारित करें जिनके बाद एडमिन होल्ड की गई राशि जारी कर सकता है',
            'mangopay-refund' => 'MangoPay रिफंड',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay बैंक विवरण',
            'type' => 'प्रकार',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'खाता धारक का नाम',
            'owner-address' => 'खाता धारक का पता',
            'owner-city' => 'खाता धारक का शहर',
            'owner-region' => 'खाता धारक का क्षेत्र',
            'owner-postal-code' => 'खाता धारक का पिन कोड',
            'country' => 'देश',
            'account-number' => 'खाता संख्या',
            'sortcode' => 'सॉर्ट कोड',
            'aba' => 'ABA',
            'bank-name' => 'बैंक का नाम',
            'institution-number' => 'संस्था संख्या',
            'branch-code' => 'शाखा कोड',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'प्रकार',
            'file' => 'फ़ाइल',
            'status' => 'स्थिति',
            'id' => 'आईडी',
            'created-at' => 'निर्माण तिथि',
        ],

        'wallet' => [
            'module-name' => 'MangoPay एडमिन वॉलेट क्रेडेंशियल्स',
            'wallet-id' => 'वॉलेट आईडी',
            'mangopay-id' => 'MangoPay आईडी',
            'create-wallet' => 'वॉलेट बनाएं',
        ],

        'transaction' => [
            'module-name' => 'MangoPay लेनदेन',
            'transaction-id' => 'लेनदेन आईडी',
            'amount' => 'राशि',
            'message' => 'संदेश',
            'status' => 'स्थिति',
            'id' => 'आईडी',
            'success' => 'सफल',
            'failed' => 'असफल',
        ],

        'amount' => [
            'module-name' => 'एस्क्रो राशि प्रबंधित करें',
        ],

        'datagrid' => [
            'order-id' => 'ऑर्डर आईडी',
            'wallet-id' => 'वॉलेट आईडी',
            'escrowed-amount' => 'एस्क्रो राशि',
            'created-at' => 'निर्माण तिथि',
            'transaction-id' => 'लेनदेन आईडी',
            'amount' => 'राशि',
            'message' => 'संदेश',
            'status' => 'स्थिति',
            'pay' => 'भुगतान करें',
            'release-amount' => 'राशि जारी करें',
            'released' => 'जारी किया गया',
            'pending' => 'बेकारी',
        ],

        'response' => [
            'wallet-not-found' => 'वॉलेट नहीं मिला। कृपया पहले वॉलेट बनाएँ।',
            'wallet-create-success' => 'वॉलेट और MangoPay आईडी सफलतापूर्वक बनाई गई।',
            'bank-details-create-success' => 'बैंक विवरण सफलतापूर्वक सहेजा गया।',
            'amount-release-success' => 'एस्क्रो राशि सफलतापूर्वक जारी की गई।',
            'escrow-not-found' => 'एस्क्रो रिकॉर्ड नहीं मिला।',
            'already-released' => 'यह एस्क्रो राशि पहले ही जारी की जा चुकी है।',
            'buyer-wallet-not-found' => 'खरीदार का वॉलेट नहीं मिला।',
            'admin-wallet-not-found' => 'व्यवस्थापक वॉलेट नहीं मिला।',
            'unsupported-bank-type' => 'असमर्थित बैंक खाता प्रकार: :type',
            'request-in-progress' => 'इस ऑर्डर के लिए एक अन्य अनुरोध प्रगति पर है। कृपया थोड़ी देर बाद फिर से प्रयास करें।',
            'wallet-exists' => 'स्टोर के पास पहले से एक MangoPay वॉलेट है; उसे बदला नहीं जाता।',
            'insufficient-escrow' => 'एस्क्रो की गई राशि इस ऑर्डर के विक्रेता भुगतानों को कवर नहीं करती।',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'उत्पाद का नाम',
            'qty-ordered' => 'ऑर्डर की गई मात्रा',
            'qty-to-refund' => 'वापसी करने के लिए मात्रा',
            'update-qty' => 'मात्रा अपडेट करें',
            'refund-summary' => 'धनवापसी सारांश',
            'refund-shipping' => 'शिपिंग वापसी',
            'adjustment-refund' => 'समायोजन वापसी',
            'adjustment-fee' => 'समायोजन शुल्क',
            'subtotal' => 'उपकुल',
            'tax' => 'कर',
            'discount' => 'छूट',
            'grand-total' => 'कुल योग',
        ],
    ],
];
