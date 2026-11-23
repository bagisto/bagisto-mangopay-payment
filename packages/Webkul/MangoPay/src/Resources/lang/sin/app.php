<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'ඔබ තත්පර කිහිපයකින් MangoPay වෙබ් අඩවියට යොමු කරනු ලැබේ.',
            'redirect-button' => 'තත්පර 10ක් ඇතුළත යොමු නොවුණහොත් මෙතන ක්ලික් කරන්න...',
            'unavailable' => 'MangoPay ගෙවීම් ක්‍රමය දැනට ලබා ගත නොහැක. කරුණාකර වෙනත් ගෙවීම් ක්‍රමයක් තෝරන්න හෝ පරිපාලක අමතන්න.',
            'canceled' => 'MangoPay ගෙවීම අවලංගු කර ඇත.',
            'cart-not-found' => 'MangoPay කරත්තය හමු නොවීය. කරුණාකර නැවත ඇණවුම කිරීමට උත්සාහ කරන්න.',
            'wallet-not-found' => 'මෙම ඇණවුම සඳහා MangoPay පසුම්බිය හමු නොවීය.',
            'payment-not-confirmed' => 'ඔබගේ MangoPay ගෙවීම තහවුරු කළ නොහැකි වූ බැවින් ඇණවුමක් සිදු නොකළේය.',
            'payment-refunded' => 'ඔබගේ කාඩ්පතින් අය කළ නමුත් ඇණවුම සිදු කළ නොහැකි වූ බැවින් ගෙවීම ආපසු ලබා දී ඇත.',
        ],

        'mangopay' => [
            'not-a-seller' => 'MangoPay ගෙවීම් සැකසුම් විකුණුම්කරුවන්ට පමණක් ලබා ගත හැකිය.',

            'bank-details' => [
                'title' => 'බැංකු විස්තර',
                'save-btn' => 'බැංකු විස්තර සුරකින්න',
                'save-success' => 'බැංකු විස්තර සාර්ථකව සුරකින ලදී.',
            ],

            'kyc' => [
                'title' => 'KYC ලේඛන',
                'create-title' => 'KYC ලේඛනයක් එක් කරන්න',
                'create-btn' => 'ලේඛනයක් එක් කරන්න',
                'save-btn' => 'ලේඛනය උඩුගත කරන්න',
                'save-success' => 'KYC ලේඛනය සාර්ථකව උඩුගත කරන ලදී.',
                'bank-required' => 'KYC ලේඛන උඩුගත කිරීමට පෙර ඔබගේ බැංකු විස්තර ඉදිරිපත් කරන්න.',
                'type' => 'ලේඛන වර්ගය',
                'file' => 'ලේඛන ගොනුව',

                'types' => [
                    'identity-proof' => 'අනන්‍යතා සාක්ෂිය',
                    'registration-proof' => 'ලියාපදිංචි සාක්ෂිය',
                    'articles-of-association' => 'සංස්ථාපන ලිඛිත',
                    'shareholder-declaration' => 'කොටස් හිමියන්ගේ ප්‍රකාශය',
                    'address-proof' => 'ලිපින සාක්ෂිය',
                ],
            ],

            'transactions' => [
                'title' => 'ක්රෙඩිට්',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'සුරකින්න',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'සාමාන්‍ය',
                'description' => 'විස්තරය',
                'title' => 'ශීර්ෂය',
                'enable' => 'සක්‍රීය කරන්න',
                'sandbox' => 'Sandbox',
                'status' => 'තත්ත්වය',
                'sort-order' => 'වර්ගීකරණ අනුපිළිවෙල',
                'client-id' => 'සේවාදායක හැඳුනුම්පත',
                'passphrase' => 'මුරපද වාක්‍යය',
                'logo' => 'ලාංඡනය',
                'logo-information' => 'රූප විභේදනය 55px × 45px විය යුතුය',
                'production-mode-info' => 'නිෂ්පාදන ප්‍රකාරය සඳහා Sandbox අක්‍රිය කරන්න.',
                'info' => 'MangoPay ගෙවීම් ද්වාර සැකසුම්',
            ],
        ],

        'system' => [
            'mangopay-id' => 'Mangopay හැඳුනුම්පත',
            'wallet-id' => 'පසුම්බි හැඳුනුම්පත',
            'no-of-days' => 'පරිපාලකයාට රඳවා ඇති මුදල මුදා හැරිය හැකි දින ගණන සකසන්න',
            'mangopay-refund' => 'MangoPay ආපසු ගෙවීම',
        ],

        'bank-details' => [
            'module-name' => 'MangoPay බැංකු විස්තර',
            'type' => 'වර්ගය',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'හිමිකරුගේ නම',
            'owner-address' => 'හිමිකරුගේ ලිපිනය',
            'owner-city' => 'හිමිකරුගේ නගරය',
            'owner-region' => 'හිමිකරුගේ කලාපය',
            'owner-postal-code' => 'හිමිකරුගේ තැපැල් කේතය',
            'country' => 'රට',
            'account-number' => 'ගිණුම් අංකය',
            'sortcode' => 'බැංකු කේතය',
            'aba' => 'ABA',
            'bank-name' => 'බැංකුවේ නම',
            'institution-number' => 'ආයතන අංකය',
            'branch-code' => 'ශාඛා කේතය',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'වර්ගය',
            'file' => 'ගොනුව',
            'status' => 'තත්ත්වය',
            'id' => 'හැඳුනුම්පත',
            'created-at' => 'නිර්මාණය කළ දිනය',
        ],

        'wallet' => [
            'module-name' => 'MangoPay පරිපාලක පසුම්බි අක්තපත්‍ර',
            'wallet-id' => 'පසුම්බි හැඳුනුම්පත',
            'mangopay-id' => 'MangoPay හැඳුනුම්පත',
            'create-wallet' => 'පසුම්බිය සාදන්න',
        ],

        'transaction' => [
            'module-name' => 'MangoPay ගනුදෙනුව',
            'transaction-id' => 'ගනුදෙනු හැඳුනුම්පත',
            'amount' => 'මුදල',
            'message' => 'පණිවිඩය',
            'status' => 'තත්ත්වය',
            'id' => 'හැඳුනුම්පත',
            'success' => 'සාර්ථකයි',
            'failed' => 'අසාර්ථකයි',
        ],

        'amount' => [
            'module-name' => 'Escrow මුදල කළමනාකරණය කරන්න',
        ],

        'datagrid' => [
            'order-id' => 'ඇණවුම් හැඳුනුම්පත',
            'wallet-id' => 'පසුම්බි හැඳුනුම්පත',
            'escrowed-amount' => 'Escrow මුදල',
            'created-at' => 'නිර්මාණය කළ දිනය',
            'transaction-id' => 'ගනුදෙනු හැඳුනුම්පත',
            'amount' => 'මුදල',
            'message' => 'පණිවිඩය',
            'status' => 'තත්ත්වය',
            'pay' => 'ගෙවන්න',
            'release-amount' => 'මුදල මුදා හරින්න',
            'released' => 'නිදහස් කරන ලදී',
            'pending' => 'රටට සහභාගී',
        ],

        'response' => [
            'wallet-not-found' => 'පසුම්බිය හමු නොවීය. කරුණාකර පළමුව පසුම්බියක් සාදන්න.',
            'wallet-create-success' => 'මුදල් පසුම්බිය සහ MangoPay හැඳුනුම්පත සාර්ථකව නිර්මාණය කරන ලදී.',
            'bank-details-create-success' => 'බැංකු විස්තර සාර්ථකව සුරකින ලදී.',
            'amount-release-success' => 'තැන්පත් කළ මුදල සාර්ථකව නිදහස් කරන ලදී.',
            'escrow-not-found' => 'එස්ක්‍රෝ වාර්තාව හමු නොවීය.',
            'already-released' => 'මෙම එස්ක්‍රෝ මුදල දැනටමත් නිදහස් කර ඇත.',
            'buyer-wallet-not-found' => 'ගැනුම්කරුගේ පසුම්බිය හමු නොවීය.',
            'admin-wallet-not-found' => 'පරිපාලක පසුම්බිය හමු නොවීය.',
            'unsupported-bank-type' => 'සහාය නොදක්වන බැංකු ගිණුම් වර්ගය: :type',
            'request-in-progress' => 'මෙම ඇණවුම සඳහා තවත් ඉල්ලීමක් ක්‍රියාත්මක වෙමින් පවතී. කරුණාකර ටික වේලාවකින් නැවත උත්සාහ කරන්න.',
            'wallet-exists' => 'වෙළඳසැලට දැනටමත් MangoPay පසුම්බියක් ඇත; එය ප්‍රතිස්ථාපනය නොකෙරේ.',
            'insufficient-escrow' => 'එස්ක්‍රෝ කළ මුදල මෙම ඇණවුමේ විකුණුම්කරුවන්ගේ ගෙවීම් ආවරණය නොකරයි.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'නිෂ්පාදන නම',
            'qty-ordered' => 'ඇණවුම් කළ ප්‍රමාණය',
            'qty-to-refund' => 'ආදාන කිරීමට :qty',
            'update-qty' => 'ප්‍රමාණය යාවත්කාලීන කරන්න',
            'refund-summary' => 'ආපසු ගෙවීම් සාරාංශය',
            'refund-shipping' => 'භාරය කිරීම',
            'adjustment-refund' => 'අභ්‍යාවශ්‍ය ආදානය',
            'adjustment-fee' => 'අභ්‍යාවශ්‍ය ගානය',
            'subtotal' => 'උප මුදල',
            'tax' => 'බද්ද',
            'discount' => 'වට්ටම්',
            'grand-total' => 'මහේ මුලු මුදල',
        ],
    ],
];
