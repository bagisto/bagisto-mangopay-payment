<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Veți fi redirecționat către site-ul MangoPay în câteva secunde.',
            'redirect-button' => 'Faceți clic aici dacă nu sunteți redirecționat în 10 secunde...',
            'unavailable' => 'Metoda de plată MangoPay nu este disponibilă momentan. Alegeți altă metodă de plată sau contactați administratorul.',
            'canceled' => 'Plata MangoPay a fost anulată.',
            'cart-not-found' => 'Coșul MangoPay nu a fost găsit. Încercați din nou să plasați comanda.',
            'wallet-not-found' => 'Portofelul MangoPay nu a fost găsit pentru această comandă.',
            'payment-not-confirmed' => 'Plata MangoPay nu a putut fi confirmată, așa că nu a fost plasată nicio comandă.',
            'payment-refunded' => 'Cardul a fost debitat, dar comanda nu a putut fi plasată, așa că plata a fost rambursată.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Setările de plată MangoPay sunt disponibile doar pentru vânzători.',

            'bank-details' => [
                'title' => 'Detalii bancare',
                'save-btn' => 'Salvează detaliile bancare',
                'save-success' => 'Detaliile bancare au fost salvate cu succes.',
            ],

            'kyc' => [
                'title' => 'Documente KYC',
                'create-title' => 'Adaugă document KYC',
                'create-btn' => 'Adaugă document',
                'save-btn' => 'Încarcă document',
                'save-success' => 'Documentul KYC a fost încărcat cu succes.',
                'bank-required' => 'Vă rugăm să trimiteți detaliile bancare înainte de a încărca documente KYC.',
                'type' => 'Tip document',
                'file' => 'Fișier document',

                'types' => [
                    'identity-proof' => 'Dovadă de identitate',
                    'registration-proof' => 'Dovadă de înregistrare',
                    'articles-of-association' => 'Act constitutiv',
                    'shareholder-declaration' => 'Declarație a acționarilor',
                    'address-proof' => 'Dovadă de adresă',
                ],
            ],

            'transactions' => [
                'title' => 'Tranzacții',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Salvează',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'General',
                'description' => 'Descriere',
                'title' => 'Titlu',
                'enable' => 'Activează',
                'sandbox' => 'Sandbox',
                'status' => 'Stare',
                'sort-order' => 'Ordine de sortare',
                'client-id' => 'ID client',
                'passphrase' => 'Frază de acces',
                'logo' => 'Siglă',
                'logo-information' => 'Rezoluția imaginii ar trebui să fie de aproximativ 55px X 45px',
                'production-mode-info' => 'Pentru modul de producție dezactivați Sandbox.',
                'info' => 'Setările gateway-ului de plată MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID MangoPay',
            'wallet-id' => 'ID portofel',
            'no-of-days' => 'Setați numărul de zile după care administratorul poate elibera suma reținută',
            'mangopay-refund' => 'Rambursare MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Detalii bancare',
            'type' => 'Tip',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Numele titularului',
            'owner-address' => 'Adresa titularului',
            'owner-city' => 'Orașul titularului',
            'owner-region' => 'Regiunea titularului',
            'owner-postal-code' => 'Codul poștal al titularului',
            'country' => 'Țară',
            'account-number' => 'Număr de cont',
            'sortcode' => 'Cod de sortare',
            'aba' => 'ABA',
            'bank-name' => 'Numele băncii',
            'institution-number' => 'Numărul instituției',
            'branch-code' => 'Codul sucursalei',
        ],

        'kyc' => [
            'module-name' => 'KYC',
            'type' => 'Tip',
            'file' => 'Fișier',
            'status' => 'Stare',
            'id' => 'ID',
            'created-at' => 'Creat la',
        ],

        'wallet' => [
            'module-name' => 'Credențiale portofel administrator MangoPay',
            'wallet-id' => 'ID portofel',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Creează portofel',
        ],

        'transaction' => [
            'module-name' => 'Tranzacție',
            'transaction-id' => 'ID tranzacție',
            'amount' => 'Sumă',
            'message' => 'mesaj',
            'status' => 'Stare',
            'id' => 'ID',
            'success' => 'Reușit',
            'failed' => 'Eșuat',
        ],

        'amount' => [
            'module-name' => 'Gestionează sumele reținute',
        ],

        'datagrid' => [
            'order-id' => 'ID comandă',
            'wallet-id' => 'ID portofel',
            'escrowed-amount' => 'Sumă reținută',
            'created-at' => 'Creat la',
            'transaction-id' => 'ID tranzacție',
            'amount' => 'Sumă',
            'message' => 'Mesaj',
            'status' => 'Stare',
            'pay' => 'Plătește',
            'release-amount' => 'Eliberează suma',
            'released' => 'Eliberată',
            'pending' => 'În așteptare',
        ],

        'response' => [
            'wallet-not-found' => 'Portofelul nu a fost găsit. Vă rugăm să creați mai întâi un portofel.',
            'wallet-create-success' => 'Portofelul și ID-ul MangoPay au fost create cu succes.',
            'bank-details-create-success' => 'Detaliile bancare au fost salvate cu succes.',
            'amount-release-success' => 'Suma reținută a fost eliberată cu succes.',
            'escrow-not-found' => 'Înregistrarea escrow nu a fost găsită.',
            'already-released' => 'Această sumă din escrow a fost deja eliberată.',
            'buyer-wallet-not-found' => 'Portofelul cumpărătorului nu a fost găsit.',
            'admin-wallet-not-found' => 'Portofelul administratorului nu a fost găsit.',
            'unsupported-bank-type' => 'Tip de cont bancar neacceptat: :type',
            'request-in-progress' => 'O altă cerere pentru această comandă este în curs. Vă rugăm să încercați din nou în curând.',
            'wallet-exists' => 'Magazinul are deja un portofel MangoPay; acesta nu este înlocuit.',
            'insufficient-escrow' => 'Suma aflată în escrow nu acoperă plățile către vânzătorii acestei comenzi.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Numele produsului',
            'qty-ordered' => 'Cantitate comandată',
            'qty-to-refund' => 'Cantitate de rambursat',
            'update-qty' => 'Actualizează cantitatea',
            'refund-summary' => 'Rezumatul rambursării',
            'refund-shipping' => 'Rambursare transport',
            'adjustment-refund' => 'Ajustare rambursare',
            'adjustment-fee' => 'Taxă de ajustare',
            'subtotal' => 'Subtotal',
            'tax' => 'Taxă',
            'discount' => 'Reducere',
            'grand-total' => 'Total general',
        ],
    ],
];
