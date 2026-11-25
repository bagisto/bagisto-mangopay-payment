<?php

return [

    'shop' => [
        'standard' => [
            'redirect-message' => 'Za kilka sekund nastąpi przekierowanie na stronę MangoPay.',
            'redirect-button' => 'Kliknij tutaj, jeśli przekierowanie nie nastąpi w ciągu 10 sekund...',
            'unavailable' => 'Metoda płatności MangoPay jest obecnie niedostępna. Wybierz inną metodę płatności lub skontaktuj się z administratorem.',
            'canceled' => 'Płatność MangoPay została anulowana.',
            'cart-not-found' => 'Nie znaleziono koszyka MangoPay. Spróbuj ponownie złożyć zamówienie.',
            'wallet-not-found' => 'Nie znaleziono portfela MangoPay dla tego zamówienia.',
            'payment-not-confirmed' => 'Nie udało się potwierdzić płatności MangoPay, więc zamówienie nie zostało złożone.',
            'payment-refunded' => 'Karta została obciążona, ale nie udało się złożyć zamówienia, więc płatność została zwrócona.',
        ],

        'mangopay' => [
            'not-a-seller' => 'Ustawienia wypłat MangoPay są dostępne tylko dla sprzedawców.',

            'bank-details' => [
                'title' => 'Dane bankowe',
                'save-btn' => 'Zapisz dane bankowe',
                'save-success' => 'Dane bankowe zostały zapisane pomyślnie.',
            ],

            'kyc' => [
                'title' => 'Dokumenty KYC',
                'create-title' => 'Dodaj dokument KYC',
                'create-btn' => 'Dodaj dokument',
                'save-btn' => 'Prześlij dokument',
                'save-success' => 'Dokument KYC został przesłany pomyślnie.',
                'bank-required' => 'Prześlij swoje dane bankowe przed przesłaniem dokumentów KYC.',
                'type' => 'Typ dokumentu',
                'file' => 'Plik dokumentu',

                'types' => [
                    'identity-proof' => 'Dowód tożsamości',
                    'registration-proof' => 'Dowód rejestracji',
                    'articles-of-association' => 'Umowa spółki',
                    'shareholder-declaration' => 'Oświadczenie akcjonariuszy',
                    'address-proof' => 'Potwierdzenie adresu',
                ],
            ],

            'transactions' => [
                'title' => 'Transakcje',
            ],
        ],
    ],

    'admin' => [
        'mangopay' => [
            'save-btn-title' => 'Zapisz',
            'module-name' => 'MangoPay',

            'configuration' => [
                'module-name' => 'MangoPay',
                'general' => 'Ogólne',
                'description' => 'Opis',
                'title' => 'Tytuł',
                'enable' => 'Włącz',
                'sandbox' => 'Piaskownica',
                'status' => 'Status',
                'sort-order' => 'Kolejność sortowania',
                'client-id' => 'ID klienta',
                'passphrase' => 'Hasło',
                'logo' => 'Logo',
                'logo-information' => 'Rozdzielczość obrazu powinna wynosić 55px × 45px',
                'production-mode-info' => 'W trybie produkcyjnym wyłącz Piaskownicę.',
                'info' => 'Ustawienia bramki płatniczej MangoPay',
            ],
        ],

        'system' => [
            'mangopay-id' => 'ID Mangopay',
            'wallet-id' => 'ID portfela',
            'no-of-days' => 'Ustaw liczbę dni, po których administrator może zwolnić zatrzymaną kwotę',
            'mangopay-refund' => 'Zwrot MangoPay',
        ],

        'bank-details' => [
            'module-name' => 'Dane bankowe MangoPay',
            'type' => 'Typ',
            'iban' => 'IBAN',
            'bic' => 'BIC',
            'owner-name' => 'Nazwa właściciela',
            'owner-address' => 'Adres właściciela',
            'owner-city' => 'Miasto właściciela',
            'owner-region' => 'Region właściciela',
            'owner-postal-code' => 'Kod pocztowy właściciela',
            'country' => 'Kraj',
            'account-number' => 'Numer konta',
            'sortcode' => 'Kod bankowy',
            'aba' => 'ABA',
            'bank-name' => 'Nazwa banku',
            'institution-number' => 'Numer instytucji',
            'branch-code' => 'Kod oddziału',
        ],

        'kyc' => [
            'module-name' => 'MangoPay KYC',
            'type' => 'Typ',
            'file' => 'Plik',
            'status' => 'Status',
            'id' => 'ID',
            'created-at' => 'Data utworzenia',
        ],

        'wallet' => [
            'module-name' => 'Dane portfela administratora MangoPay',
            'wallet-id' => 'ID portfela',
            'mangopay-id' => 'ID MangoPay',
            'create-wallet' => 'Utwórz portfel',
        ],

        'transaction' => [
            'module-name' => 'Transakcja MangoPay',
            'transaction-id' => 'ID transakcji',
            'amount' => 'Kwota',
            'message' => 'Wiadomość',
            'status' => 'Status',
            'id' => 'ID',
            'success' => 'Sukces',
            'failed' => 'Niepowodzenie',
        ],

        'amount' => [
            'module-name' => 'Zarządzaj kwotą escrow',
        ],

        'datagrid' => [
            'order-id' => 'ID zamówienia',
            'wallet-id' => 'ID portfela',
            'escrowed-amount' => 'Kwota escrow',
            'created-at' => 'Data utworzenia',
            'transaction-id' => 'ID transakcji',
            'amount' => 'Kwota',
            'message' => 'Wiadomość',
            'status' => 'Status',
            'pay' => 'Zapłać',
            'release-amount' => 'Zwolnij kwotę',
            'released' => 'Zwolniono',
            'pending' => 'Oczekujące',
        ],

        'response' => [
            'wallet-not-found' => 'Nie znaleziono portfela. Najpierw utwórz portfel.',
            'wallet-create-success' => 'Portfel i identyfikator MangoPay zostały utworzone pomyślnie.',
            'bank-details-create-success' => 'Dane bankowe zostały zapisane pomyślnie.',
            'amount-release-success' => 'Kwota zdeponowana została zwolniona pomyślnie.',
            'escrow-not-found' => 'Nie znaleziono rekordu depozytu.',
            'already-released' => 'Ta kwota z depozytu została już wypłacona.',
            'buyer-wallet-not-found' => 'Nie znaleziono portfela kupującego.',
            'admin-wallet-not-found' => 'Nie znaleziono portfela administratora.',
            'unsupported-bank-type' => 'Nieobsługiwany typ konta bankowego: :type',
            'request-in-progress' => 'Dla tego zamówienia trwa już inne żądanie. Spróbuj ponownie za chwilę.',
            'wallet-exists' => 'Sklep ma już portfel MangoPay; nie zostanie on zastąpiony.',
            'insufficient-escrow' => 'Kwota w depozycie nie pokrywa wypłat dla sprzedawców tego zamówienia.',
        ],

        'refunds' => [
            'sku' => 'SKU',
            'product-name' => 'Nazwa produktu',
            'qty-ordered' => 'Zamówiona ilość',
            'qty-to-refund' => 'Ilość do zwrotu',
            'update-qty' => 'Zaktualizuj ilość',
            'refund-summary' => 'Podsumowanie zwrotu',
            'refund-shipping' => 'Zwrot kosztów dostawy',
            'adjustment-refund' => 'Korekta zwrotu',
            'adjustment-fee' => 'Opłata za korektę',
            'subtotal' => 'Suma częściowa',
            'tax' => 'Podatek',
            'discount' => 'Rabat',
            'grand-total' => 'Suma ogólna',
        ],
    ],
];
